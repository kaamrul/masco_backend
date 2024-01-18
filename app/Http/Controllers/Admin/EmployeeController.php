<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Library\Enum;
use App\Models\Stock;
use App\Models\Branch;
use App\Library\Helper;
use App\Models\Employee;
use App\Library\Response;
use App\Models\StockAssign;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\TicketService;
use App\Library\Services\Admin\EmployeeService;
use App\Http\Requests\Admin\Employee\CreateRequest;
use App\Http\Requests\Admin\Employee\UpdateRequest;

class EmployeeController extends Controller
{
    use ApiResponse;
    private $employee_service;
    private $ticket_service;

    public function __construct(EmployeeService $employee_service, TicketService $ticket_service)
    {
        $this->employee_service = $employee_service;
        $this->ticket_service = $ticket_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);

            return $this->employee_service->dataTable($filter_request);
        }

        return view('admin.pages.employee.index');
    }

    public function show(Employee $employee)
    {
        abort_unless($employee->user, 404);

        $employee->load('user');

        return view('admin.pages.employee.show', [
            'employee'          => $employee,
            'user'              => $employee->user,
            'emergency_contact' => $employee?->user?->emergency,
            'user_id'           => $employee?->user_id,
            'countries'         => Helper::getCountries(),
            'user_type'         => 'employee',
            'roles'             => auth()->user()->user_type == Enum::USER_TYPE_SUPER_ADMIN ? Role::get() : Role::getAll(),
            'address'           => $employee?->user?->address,
            'count_total'       => $this->ticket_service->countUserTicket($employee?->user?->id),
        ]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.employee.create', [
            'countries'          => Helper::getCountries(),
            'roles'              => auth()->user()->user_type == Enum::USER_TYPE_SUPER_ADMIN ? Role::get() : Role::getAll(),
            'genders'            => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'jobTitles'          => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employmentTypes'    => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'locations'          => getLocations(),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->employee_service->createEmployee($request->validated());

        if ($result) {
            return redirect()->route('admin.employee.index', $this->employee_service->data)->with('success', $this->employee_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->employee_service->message);
    }

    public function showUpdateForm(Employee $employee)
    {
        abort_unless($employee->user, 404);

        return view('admin.pages.employee.update', [
            'employee'           => $employee,
            'user'               => $employee->user,
            'countries'          => Helper::getCountries(),
            'roles'              => auth()->user()->user_type == Enum::USER_TYPE_SUPER_ADMIN ? Role::get() : Role::getAll(),
            'genders'            => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'jobTitles'          => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employmentTypes'    => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'locations'          => getLocations(),
        ]);
    }

    public function update(Employee $employee, UpdateRequest $request)
    {
        abort_unless($employee->user, 404);
        $result = $this->employee_service->updateEmployee($employee, $request->validated());

        if ($result) {
            return redirect()->route('admin.employee.show', $employee->id)->with('success', $this->employee_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->employee_service->message);
    }

    public function securityUpdate(Employee $employee, Request $request)
    {
        abort_unless($employee->user, 404);

        $this->validate($request, [
            'role_id' => 'required',
        ]);

        $employee?->user?->roles()->sync($request->role_id);

        return redirect(route('admin.employee.show', $employee->id) . '#security')->with('success', 'Successfully Updated');
    }

    public function ticketIndex(Employee $employee, Request $request)
    {
        if ($request->ajax()) {
            return $this->ticket_service->userTicketDataTable($request->status, $employee?->user?->id);
        }

        return redirect(route('admin.employee.show', $employee->id) . '#ticket');
    }
}
