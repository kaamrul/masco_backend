<?php

namespace App\Http\Controllers\Public;

use Carbon\Carbon;
use App\Models\User;
use App\Library\Enum;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.pages.home.index');
    }

    public function verifyEmail(Member $member, $type)
    {
        return view('public.pages.verify-email', [
            'type' => $type,
            'member' => $member,
        ]);
    }

    public function storeVerifyEmail(Member $member, $type)
    {
        if (($type == 'nominated_by' && $member->is_nominated != null && $member->nominated_at != null) || 
            ($type == 'seconded_by' && $member->is_seconded != null && $member->seconded_at != null)) {
            return view('public.pages.after-verify-email', [
                'message' => 'This email already verified.'
            ]);
        }
         
        if ($type == 'nominated_by') {
            $member->update([
                'is_nominated' => true,
                'nominated_at' => now(),
            ]);
        } elseif ($type == 'seconded_by') {
            $member->update([
                'is_seconded' => true,
                'seconded_at' => now(),
            ]);
        }

        return view('public.pages.after-verify-email', [
            'message' => 'Email Verified Successfully.'
        ]);
    }


    public function attendance()
    {
        $possibleVisitorToSignUp = Attendance::whereType(Enum::ATTENDANCE_TYPE_VISITOR)->whereNull('out_time')->whereDate('created_at', now()->today())->get();

        return view('public.pages.inOut.index', [
            'kaimahies'               => User::getActiveAdminEmployeeByStatus(Enum::STATUS_ACTIVE),
            'possibleVisitorToSignUp' => $possibleVisitorToSignUp,
        ]);
    }

    public function visitorSignIn(Request $request)
    {
        // TODO::will refactor this code later
        $this->validate($request, [
            'visitor_name' => 'required|max:255|string'
        ]);

        $location = Location::where('ip', $request->ip())->first();

        $data = $request->all();
        $data['in_time'] = date_format(now(), "Y-m-d H:i");
        $data['in_time_location'] = $location ? $location->name : 'Remote';
        $data['ip'] = $request->ip();
        $data['type'] = Enum::ATTENDANCE_TYPE_VISITOR;

        Attendance::create($data);

        return back()->with('success', 'You are logged in.');
    }

    public function visitorSignOut(Request $request)
    {
        // TODO::will refactor this code later
        $this->validate($request, [
            'visitor_name' => 'required'
        ]);

        $location = Location::where('ip', $request->ip())->first();

        $data = $request->all();
        $data['out_time'] = date_format(now(), "Y-m-d H:i");
        $data['out_time_location'] = $location ? $location->name : 'Remote';
        $data['ip'] = $request->ip();
        $data['type'] = Enum::ATTENDANCE_TYPE_VISITOR;

        $attendance = Attendance::find($request->visitor_name);
        unset($data['visitor_name']);
        $attendance->update($data);

        return back()->with('success', 'You are logged out.');
    }

    public function show(Employee $employee)
    {
        $attendance = Attendance::where('employee_id', $employee->id)->whereDate('created_at', now()->today())->latest()->first();

        return response()->json(['data' => $attendance]);
    }

    public function EmployeeAttendance(Request $request)
    {
        // TODO::will refactor this code later
        $this->validate($request, [
            'employee_id'        => 'required',
            'expected_back_time' => 'required_if:sign_out_type, !=, Leaving | nullable',
        ]);

        $location = Location::where('ip', $request->ip())->first();
        $time = date_format(now(), "Y-m-d H:i");

        // Get the latest attendance record of the employee that is not a leaving sign out and has an alert
        $previous_attendance = Attendance::whereEmployeeId($request->employee_id)
            ->where('created_at', '>=', Carbon::today())
            ->notLeaving()
            ->lessThanExpectedBackTime(now())
            ->alert()
            ->whereNull('delay_time')
            ->latest()
            ->first();

        if ($request->can_sign_in == 'yes') {

            $data = $request->all();
            $data['in_time'] = $time;
            $data['in_time_location'] = $location ? $location->name : 'Remote';
            $data['ip'] = $request->ip();
            $data['type'] = Enum::ATTENDANCE_TYPE_EMPLOYEE;

            // Update the previous attendance record with the sign in time, alert status and delay time
            if ($previous_attendance) {
                $signInTime = Carbon::parse($data['in_time']);
                $value['is_alert'] = 0;
                $value['delay_time'] = $signInTime->diff($previous_attendance->expected_back_time)->format('%H:%I');

                $previous_attendance->update($value);
            }

            Attendance::create($data);

            return redirect(route('public.sign.in') . '#tab-kaimahi')->with('success', 'You are logged in.');
        }

        if ($request->sign_out_type != Enum::SIGN_OUT_TYPE_LEAVING && $request->expected_back_time == null) {
            throw ValidationException::withMessages(['expected_back_time' => 'Expected back time is required']);
        }

        $data = $request->all();
        $data['out_time'] = $time;
        $data['out_time_location'] = $location ? $location->name : 'Remote';
        $data['ip'] = $request->ip();
        $data['type'] = Enum::ATTENDANCE_TYPE_EMPLOYEE;

        if ($request->expected_back_time) {
            $data['expected_back_time'] = Carbon::createFromFormat('H:i', $request->expected_back_time);
            $data['is_alert'] = 1;
        }

        $attendance = Attendance::whereEmployeeId($request->employee_id)->whereDate('created_at', now()->today())->latest()->first();

        $attendance->update($data);

        return redirect(route('public.sign.in') . '#tab-kaimahi')->with('success', 'You are logged out.');
    }
}
