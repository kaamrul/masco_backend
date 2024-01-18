<?php

namespace App\Library\Services\Admin;

use Exception;

use App\Models\User;
use App\Library\Helper;
use App\Models\EmailSignature;
use Yajra\DataTables\Facades\DataTables;

class EmailSignatureService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            $actionHtml = '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="showViewEmailSignatureModal(\'' . $row->id . '\')" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.config.more_settings.email_signature.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="#"  onclick="confirmFormModal(\'' . route('admin.config.more_settings.email_signature.delete.api', $row->id) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash"></i> Delete</a>';
        } else {
            $actionHtml = '';
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

    public function dataTable()
    {
        $data = EmailSignature::get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('signature', function ($row) {
                    return $row->signature;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at ? getFormattedDateTime($row->updated_at) : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action','signature'])
                ->make(true);
    }

    public function createEmailSignature(array $data): bool
    {
        try {
            $data['operator_id'] = User::getAuthUser()->id;
            EmailSignature::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateEmailSignature(EmailSignature $email_signature, array $data): bool
    {
        try {
            $data['operator_id'] = User::getAuthUser()->id;
            $email_signature->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch(Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
