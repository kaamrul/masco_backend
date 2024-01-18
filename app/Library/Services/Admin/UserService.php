<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    public function updatePassword(User $user, array $data)
    {
        $this->checkRolePermission($user, 'user_update_password');

        try {
            $user->update([
                'password' => bcrypt($data['password']),
            ]);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateStatus(User $user, int $data)
    {
        $this->checkRolePermission($user, 'user_update_status');

        try {
            $user->update(['status' => $data]);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function deleteUser(User $user)
    {
        DB::beginTransaction();

        // try {
        if ($user->isEmployee()) {
            $user->employeeBranches()->delete();
            $user->employee()->delete();
        } elseif ($user->isCustomer()) {
            $user->delete();
        }

        deleteFile([$user->avatar]);

        $user->emergency()->delete();
        $user->address()->delete();
        $user->attachments()->delete();
        $user->delete();
        DB::commit();

        return $this->handleSuccess('Successfully Deleted');
        // } catch (Exception $e) {
        //     Helper::log($e);

        //     return $this->handleException($e);
        // }
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        abort_unless($user, 404, 'Not found');

        $this->checkRolePermission($user, 'user_restore');

        DB::beginTransaction();

        // try {
        $user->restore();

        if ($user->isEmployee()) {
            $user->employee()->restore();
        }

        DB::commit();

        return $this->handleSuccess('Successfully Restored');
        // } catch (Exception $e) {
        //     Helper::log($e);

        //     return $this->handleException($e);
        // }
    }

    public function checkRolePermission(User $user, string $permission_suffix)
    {
        $auth_role = User::getAuthUser()->role();

        if ($user->isEmployee() || $user->isAdmin()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.employee.index');
        } elseif ($user->isMember()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.member.index');
        } elseif ($user->isDayMember()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.member.day_member.index');
        } elseif ($user->isSkipper()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.skipper.index');
        }

        //This redirect variable will be used only for delete operation
        return $redirect;
    }

    //==================----- For User Profile -----=====================//
    public function updateProfile($data)
    {
        DB::beginTransaction();

        try {
            $user = User::getAuthUser();
            $operator_id = auth()->id();

            // User
            $user_data = $data['user'];
            $user_data['phone'] = $data['mobile'];
            $user_data['operator_id'] = $operator_id;

            if (isset($user_data['avatar'])) {
                deleteFile($user->avatar);
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            $data['operator_id'] = $operator_id;

            $user->update($user_data);
            unset($data['user']);

            // Address
            $address_data = $data['address'];
            $address_data['user_id'] = $user->id;
            $address_data['operator_id'] = $operator_id;

            if($user->address) {
                $user->address->update($address_data);
            } else {
                Address::create($address_data);
            }
            unset($data['address']);

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateProfilePassword($data)
    {
        DB::beginTransaction();

        try {
            $user = User::getAuthUser();
            $user->update([
                'password' => bcrypt($data['password']),
            ]);

            return $this->handleSuccess('Successfully Password Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
