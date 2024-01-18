<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Helper;
use App\Models\Tournament;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Yajra\DataTables\Facades\DataTables;

class NotificationService extends BaseService
{
    private function filter(array $params)
    {
        $query = Notification::with('user');
        $query->orderBy('id', 'desc');

        if (isset($params['is_for_emp'])) {
            $query->where('is_for_emp', 1);
        }

        return $query->get();
    }

    private function actionHtml($row, $user_role)
    {
        if (Helper::hasAuthRolePermission('notification_delete')) {
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.notification.show', $row->id) . '" ><i class="fas fa-eye"></i> View </a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmModal(deleteNotification, ' . $row->id . ', \'Are you sure to delete operation?\')" ><i class="far fa-trash-alt"></i> Delete </a>';
        } else {
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            ->addColumn('user_id', function ($row) {
                return $row->user_id ? $row?->user?->full_name : 'N/A';
            })
            ->addColumn('subject', function ($row) {
                return '<a class="text-primary" href="javascript:void(0)" onclick="showViewModal(\'' . $row->message . '\', \'' . $row->subject . '\', \'' . $row->send_date . '\')" > ' . $row->subject . ' </a>';
            })
            ->addColumn('employee', function ($row) {
                return $row->is_for_emp ? '<i class="fas fa-check-circle"></i>' : '';
            })
            ->addColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->addColumn('message', function ($row) {
                return substr($row->message, 0, 50);
            })
            ->addColumn('send_date', function ($row) {
                return $row->send_date ? getFormattedDate($row->send_date) : 'N/A';
            })
            ->addColumn('action', function ($row) use ($user_role) {
                return $this->actionHtml($row, $user_role);
            })
            ->rawColumns(['subject', 'employee', 'member', 'message', 'created_at', 'action'])
            ->make(true);
    }

    public function dataTableForEmployee()
    {
        $data = Notification::with('user')->where('is_for_emp', 1)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('subject', function ($row) {
                return '<a class="text-primary" href="javascript:void(0)" onclick="showViewModal(\'' . $row->message . '\', \'' . $row->subject . '\', \'' . $row->send_date . '\')" > ' . $row->subject . ' </a>';
            })
            ->addColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->addColumn('message', function ($row) {
                return substr($row->message, 0, 50);
            })
            ->addColumn('send_date', function ($row) {
                return $row->send_date ? getFormattedDate($row->send_date) : 'N/A';
            })
            ->rawColumns(['subject', 'message', 'created_at', 'send_date'])
            ->make(true);
    }

    public function createNotification(array $data): bool
    {
        try {
            $data['user_id'] = auth()->id();
            $notification_data = Notification::create($data);
            $notification_recipient = [];
            
            $query = User::select('*');

            if (isset($data['user_type']) && $data['user_type'] != []) {
                $query->whereIn('user_type', $data['user_type']);
            }

            if (isset($data['user_status']) && $data['user_status'] != []) {
                $query->whereIn('status', $data['user_status']);
            }

            $users = $query->get();

            foreach ($users as $user) {
                $notification_recipient['user_id'] = $user->id;
                $notification_recipient['notification_id'] = $notification_data->id;

                NotificationRecipient::create($notification_recipient);
            }
            
            return $this->handleSuccess('Successfully Created', $notification_data);
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function deleteNotification(Notification $notification)
    {
        try {
            $notification_data = $notification;
            $notification->delete();

            return $this->handleSuccess('Successfully deleted', $notification_data);
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public static function updateByType(string $type, array $data)
    {
        return Notification::where('type', $type)->update($data);
    }

    //=================== Notification Recipients start  ===============///
    private function statusHtml($row)
    {
        if ($row->is_sent == 0 && $row->is_try == 1) {
            $class = 'badge-danger';
            $status = 'Failed';
        } elseif ($row->is_sent == 1 && $row->is_try == 1) {
            $class = 'badge-success';
            $status = 'Sent';
        } else {
            $class = 'badge-warning';
            $status = 'Unsent';
        }

        return '<div class="badge ' . $class . '"><strong class="px-2">' . $status . '</strong></div>';
    }

    private function actionHtmlForRecipient($row)
    {
        if ($row->is_try == 1 && $row->is_sent == 0) {

            return '<a class="btn btn-warning btn-sm text-white" href="javascript:void(0)" onclick="confirmModal(resendEmail, ' . $row->id . ', \'Are you sure to Resend operation?\')"><i class="fas fa-reply"></i> Resend</a>';
        } elseif ($row->is_sent == 1 && $row->is_try == 1) {

            return '<button class="edit btn btn-sm btn-success pr-2" disabled> <i class="fa-solid fa-check"></i> Sent </button>';
        } else {

            return '<button class="edit btn btn-sm btn-info pr-2" disabled> <i class="fa-solid fa-rotate"></i> Pending </button>';
        }
    }

    public function recipientDataTable(Notification $notification)
    {
        $data = $notification->recipients->load('user');

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('user_id', function ($row) {
                return $row?->user->full_name;
            })

            ->editColumn('email', function ($row) {
                return  $row?->user->email;
            })

            ->editColumn('send_status', function ($row) {
                return $this->statusHtml($row);
            })

            ->addColumn('action', function ($row) {
                return $this->actionHtmlForRecipient($row);
            })

            ->rawColumns(['action', 'user_id', 'send_status'])
            ->make(true);
    }
}
