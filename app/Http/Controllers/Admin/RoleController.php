<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Library\Response;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Role\CreateRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_role = User::getAuthUserRole();

            $query = Role::select('*');

            $data = $user_role->slug == Enum::USER_TYPE_SUPER_ADMIN ? $query : $query->whereNot('id', 1);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return $this->getActionHtml($row);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.config.role.index');
    }

    private function getActionHtml($row)
    {
        $actionHtml = '';

        if ($row->slug != Enum::USER_TYPE_SUPER_ADMIN) {
            if (Helper::hasAuthRolePermission('role_permission')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.config.role.permission', $row->id) . '" ><i class="fas fa-key"></i> Permissions</a>';
            }

            if (Helper::hasAuthRolePermission('role_update')) {
                $actionHtml .= '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="clickEditAction(' . $row->id . ')" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('role_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmModal(deleteRole, ' . $row->id . ', \'Are you sure to delete operation?\')" ><i class="far fa-trash-alt"></i> Delete</a>';
            }
        } else {
            return '';
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

    public function showApi(Role $role)
    {
        return $role;
    }

    public function createApi(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            Role::create($data);

            return Response::success(__('Successfully created'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return Response::error(__('Unable to create'), [], 500);
        }
    }

    public function updateApi(Role $role, UpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $role->update($data);

            return Response::success(__('Successfully updated'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return Response::error(__('Unable to update'), [], 500);
        }
    }

    public function deleteApi(Role $role)
    {
        try {
            abort_if($role->slug == Enum::USER_TYPE_SUPER_ADMIN, 404);
            $role->delete();

            return Response::success(__('Successfully deleted'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return Response::error(__('Unable to delete'), [], 500);
        }
    }

    public function permissions(Role $role)
    {
        if ($role->slug == Enum::USER_TYPE_SUPER_ADMIN) {
            return redirect()->route('admin.config.role.index')->with('error', __('Permission denied'));
        }

        $role_permissions = $role->permissions()->pluck('id')->toArray();
        $all_permissions = Permission::get()->groupBy('group');

        return view('admin.pages.config.role.permission', [
            'role'             => $role,
            'role_permissions' => $role_permissions,
            'all_permissions'  => $all_permissions
        ]);
    }

    public function updatePermissions(Role $role, Request $request)
    {
        if ($role->slug == Enum::USER_TYPE_SUPER_ADMIN) {
            return back()->with('error', __('Permission denied'));
        }

        $permission_ids = $request->permission_ids;
        $role_permissions = $role->permissions();
        $role_permissions->detach();
        $role_users = $role->users;

        foreach ($role_users as $user) {
            $user->permissions()->detach();
        }

        if (!empty($permission_ids)) {
            foreach ($permission_ids as $permission_id) {
                $permission = Permission::find($permission_id);
                $role_permissions->attach($permission);

                foreach ($role_users as $user) {
                    $user->permissions()->attach($permission);
                }
            }
        }

        return back()->with('success', __('Successfully updated'));
    }
}
