<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Stock;
use App\Library\Helper;
use App\Models\Address;
use App\Models\Product;
use App\Models\Employee;
use App\Models\StockAssign;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\Stock\StockHistoryEvent;
use App\Models\EmployeeBranch;
use Yajra\DataTables\Facades\DataTables;

class EmployeeService extends BaseService
{
    private function filter(array $params)
    {
        $query = User::select('employees.id as employee_id', 'employees.*', 'users.*')
            ->join('employees', 'users.id', '=', 'employees.user_id')
            ->whereIn('users.user_type', [Enum::USER_TYPE_SUPER_ADMIN, Enum::USER_TYPE_ADMIN, Enum::USER_TYPE_EMPLOYEE]);

        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
            $query->whereNotNull('employees.deleted_at');
        } elseif (isset($params['status'])) {
            $query->where('status', $params['status']);
            $query->whereNull('employees.deleted_at');
        }

        return $query->get();
    }

    private function actionHtml($row, $user_role)
    {
        if (is_null($row->employee_id)) {
            return '';
        }

        $actionHtml = '';

        if (Helper::hasAuthRolePermission('user_restore') && $row->deleted_at) {
            $actionHtml .= '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="confirmModal(restoreEmployee, ' . $row->id . ', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-restore-alt"></i> Restore</a>';
        } elseif ($row->employee_id && !$row->deleted_at) {
            if (Helper::hasAuthRolePermission('employee_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.employee.show', $row->employee_id) . '" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('employee_update') && $row->user_type != Enum::USER_TYPE_SUPER_ADMIN) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.employee.update', $row->employee_id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);
        $user_role = User::getAuthUserRole();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) use ($user_role) {
                $name = $row?->full_name;

                return !Helper::hasAuthRolePermission('employee_show') || $row->deleted_at || $row->employee_id == null ? $name : '<a href="' . route('admin.employee.show', $row->employee_id) . '" class="text-success pr-2">' . $name . '</a>';
            })
            ->addColumn('emp_type', function ($row) {
                return ucwords(str_replace('_', ' ', $row->employment_type));
            })
            ->addColumn('dob', function ($row) {
                return getFormattedDate($row->dob);
            })
            ->addColumn('action', function ($row) use ($user_role) {
                return $this->actionHtml($row, $user_role);
            })
            ->rawColumns(['name', 'action', 'emp_type', 'dob'])
            ->make(true);
    }

    public function createEmployee(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();

            // User
            $user_data = $data['user'];
            $user_data['phone'] = $data['mobile'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = $data['operator_id'];
            $user_data['status'] = Enum::STATUS_PENDING;
            $user_data['password'] = bcrypt($user_data['password']);
            $user_data['user_type'] = Enum::USER_TYPE_EMPLOYEE;

            if (isset($user_data['avatar'])) {
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            unset($data['user']);
            $user = User::create($user_data);

            // Employee
            $employee_data = $data['employee'];
            $employee_data['user_id'] = $user->id;
            $employee_data['operator_id'] = $data['operator_id'];

            unset($data['employee']);
            Employee::create($employee_data);

            // Address
            $address_data = $data['address'];
            $address_data['user_id'] = $user->id;
            $address_data['operator_id'] = $data['operator_id'];

            unset($data['address']);
            Address::create($address_data);

            // Emergency Contact
            $emergency_data = $data['emergencyContact'];
            $emergency_data['user_id'] = $user->id;
            $emergency_data['created_by'] = $data['operator_id'];
            $emergency_data['mobile_number'] = $data['emergency_mobile'];

            unset($data['emergencyContact']);
            EmergencyContact::create($emergency_data);

            // Roles
            if (isset($data['role_id'])) {
                $user->roles()->attach($data['role_id']);
            }

            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateEmployee(Employee $employee, array $data): bool
    {
        DB::beginTransaction();

        //try {
        $data['operator_id'] = auth()->id();

        // User
        $user = $employee->user;
        $user_data = $data['user'];
        $user_data['phone'] = $data['mobile'];
        $user_data['operator_id'] = $data['operator_id'];
        $user_data['status'] = Enum::STATUS_PENDING;

        if (isset($user_data['avatar'])) {
            deleteFile($user->avatar);
            $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
        }

        // if ($data['user']['user_type'] == Enum::USER_TYPE_EMPLOYEE) {
        //     $user->roles()->detach();
        //     unset($data['role_id']);
        // }

        unset($data['user']);
        $user->update($user_data);

        if (isset($data['role_id'])) {
            $user->roles()->sync($data['role_id']);
        }

        // Employee
        $employee_data = $data['employee'];
        $employee_data['user_id'] = $user->id;
        $employee_data['operator_id'] = $data['operator_id'];

        unset($data['employee']);
        $employee->update($employee_data);

        // Branch
        $branch = $data['branch'];
        $branch['employee_id'] = $user->id;
        $branch['operator_id'] = $data['operator_id'];
        unset($data['branch']);

        DB::commit();

        return $this->handleSuccess('Successfully updated');
        // } catch (Exception $e) {
        //     Helper::log($e);

        //     return $this->handleException($e);
        // }
    }

    public static function updateByDesignation(string $designation, array $data)
    {
        return Employee::where('designation', $designation)->update($data);
    }

    public function createEmergencyContact(Employee $employee, array $data): bool
    {
        try {
            if (isset($data['image'])) {
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }

            $data['employee_id'] = $employee->id;
            $data['created_by'] = User::getAuthUser()->id;
            $this->data = EmergencyContact::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateEmergencyContact(EmergencyContact $emergency, array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;

            if (isset($data['image'])) {
                deleteFile($emergency->image);
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }

            $this->data = $emergency->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

}
