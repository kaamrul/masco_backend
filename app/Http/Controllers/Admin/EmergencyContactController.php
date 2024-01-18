<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Http\Traits\ApiResponse;
use App\Models\EmergencyContact;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\EmergencyContactService;
use App\Http\Requests\Admin\Employee\EmergencyContact\CreateRequest;
use App\Http\Requests\Admin\Employee\EmergencyContact\UpdateRequest;

class EmergencyContactController extends Controller
{
    use ApiResponse;

    private $emergency_service;

    public function __construct(EmergencyContactService $emergency_service)
    {
        $this->emergency_service = $emergency_service;
    }

    public function showCreateForm(User $user)
    {
        if ($user->user_type == Enum::USER_TYPE_ADMIN || $user->user_type == Enum::USER_TYPE_EMPLOYEE) {
            $route = route('admin.employee.show', $user?->employee->id) . '#emergency-contact';
        } elseif ($user->user_type == Enum::USER_TYPE_CUSTOMER ) {
            $route = route('admin.member.show.contact', $user?->member->id);
        }

        return view('admin.pages.emergency_contact.create_emergency', [
            'user'      => $user,
            'countries' => Helper::getCountries(),
            'route'     => $route,
        ]);
    }

    public function create(User $user, CreateRequest $request)
    {
        $result = $this->emergency_service->createEmergencyContact($user, $request->validated());

        if ($result) {
            if ($user->user_type == Enum::USER_TYPE_ADMIN || $user->user_type == Enum::USER_TYPE_EMPLOYEE) {
                return redirect(route('admin.employee.show', $user?->employee->id) . '#emergency-contact')->with('success', $this->emergency_service->message);
            } elseif ($user->user_type == Enum::USER_TYPE_CUSTOMER) {
                return redirect(route('admin.member.show.contact', $user?->member->id))->with('success', $this->emergency_service->message);
            }

            return redirect()->back()->with('success', $this->emergency_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->emergency_service->message);
    }

    public function showUpdateForm(EmergencyContact $emergency)
    {
        abort_unless($emergency, 404);
        $user = User::find($emergency->user_id);

        if ($user->user_type == Enum::USER_TYPE_ADMIN || $user->user_type == Enum::USER_TYPE_EMPLOYEE) {
            $route = route('admin.employee.show', $user?->employee->id) . '#emergency-contact';
        } elseif ($user->user_type == Enum::USER_TYPE_CUSTOMER) {
            $route = route('admin.member.show.contact', $user?->member->id);
        }

        return view('admin.pages.emergency_contact.update_emergency', [
            'emergency_contact' => $emergency,
            'countries'         => Helper::getCountries(),
            'route'             => $route,
        ]);
    }

    public function update(EmergencyContact $emergency, UpdateRequest $request)
    {
        abort_unless($emergency, 404);
        $result = $this->emergency_service->updateEmergencyContact($emergency, $request->validated());

        if ($result) {
            if ($emergency?->user?->user_type == Enum::USER_TYPE_ADMIN || $emergency?->user?->user_type == Enum::USER_TYPE_EMPLOYEE) {
                return redirect(route('admin.employee.show', $emergency?->user?->employee->id) . '#emergency-contact')->with('success', $this->emergency_service->message);
            } elseif ($emergency?->user?->user_type == Enum::USER_TYPE_CUSTOMER) {
                return redirect(route('admin.member.show.contact', $emergency?->user?->member->id))->with('success', $this->emergency_service->message);
            }

            return redirect()->back()->with('success', $this->emergency_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->emergency_service->message);
    }

    public function deleteApi(EmergencyContact $emergency)
    {
        abort_unless($emergency, 404);

        deleteFile($emergency->image);
        $emergency->delete();

        if ($emergency) {
            if ($emergency?->user?->user_type == Enum::USER_TYPE_EMPLOYEE) {
                return redirect(route('admin.employee.show', $emergency?->user?->employee->id) . '#emergency-contact')->with('success', $this->emergency_service->message);
            } elseif ($emergency?->user?->user_type == Enum::USER_TYPE_CUSTOMER) {
                return redirect(route('admin.member.show.contact', $emergency?->user?->member->id))->with('success', $this->emergency_service->message);
            }

            return redirect()->back()->with('success', $this->emergency_service->message);
        }

        return back()->with('error', 'Unable to delete now');
    }
}
