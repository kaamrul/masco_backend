<?php

namespace App\Http\Controllers\Admin;

use App\Library\Response;
use App\Models\ActivityLog;
use App\Models\EmailHistory;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;

;
use App\Library\Services\Admin\LogService;

class LogController extends Controller
{
    use ApiResponse;

    private $log_service;

    public function __construct(LogService $log_service)
    {
        $this->log_service = $log_service;
    }

    public function loginIndex(Request $request)
    {
        if ($request->ajax()) {
            return $this->log_service->loginDataTable();
        }

        return view('admin.pages.logs.login_history');
    }

    public function deleteLoginApi(LoginHistory $login)
    {
        $result = $this->log_service->deleteLogin($login);

        if($result) {
            return $this->response($result, $this->log_service->message);
        }

        return back()->with('error', $this->log_service->message);
    }

    public function activityIndex(Request $request)
    {
        if ($request->ajax()) {
            return $this->log_service->activityDataTable();
        }

        return view('admin.pages.logs.activity_log');
    }

    public function deleteActivity(ActivityLog $activity)
    {
        $result = $this->log_service->deleteActivity($activity);

        if($result) {
            return $this->response($result, $this->log_service->message);
        }

        return back()->with('error', $this->log_service->message);
    }

    public function activityShow(ActivityLog $activity)
    {
        return Response::success(__('Successfully deleted'), $activity->changes);
    }

    public function emailIndex(Request $request)
    {
        if ($request->ajax()) {
            return $this->log_service->emailDataTable();
        }

        return view('admin.pages.logs.email_history.index');
    }

    public function emailShow(EmailHistory $email)
    {
        return view('admin.pages.logs.email_history.show', [
            'emailHistory' => $email
        ]);
    }

    public function deleteEmail(EmailHistory $email)
    {
        $result = $this->log_service->deleteEmail($email);

        return $this->response($result, $this->log_service->message);
    }

}
