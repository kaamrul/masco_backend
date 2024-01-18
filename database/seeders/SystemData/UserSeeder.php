<?php

namespace Database\Seeders\SystemData;

use App\Models\User;
use App\Library\Enum;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
    }

    private function createAdmin()
    {
        $user = new User();
        $user->first_name = "Database";
        $user->last_name = "User";
        $user->email = config('app.admin_email');
        $user->password = bcrypt(config('app.admin_password'));
        $user->user_type = Enum::USER_TYPE_SUPER_ADMIN;
        $user->status = Enum::STATUS_ACTIVE;
        $user->phone = '01800000000';
        $user->gender = 'Male';
        $user->dob = '2000-12-12';
        $user->operator_id = 1;
        $user->save();

        $employee_data = [
            'user_id'             => $user->id,
            'operator_id'         => $user->id,
            'ethnicity'           => '',
            'job_title'           => '',
            'employment_type'     => '',
            'entitlement_to_work' => '',

            // 'ethnicity'           => getDropdown(Enum::CONFIG_DROPDOWN_ETHNICITY)[0],
            // 'iwi'                 => getDropdown(Enum::CONFIG_DROPDOWN_IWI)[0],
            // 'job_title'           => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE)[0],
            // 'employment_type'     => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS)[0],
            // 'entitlement_to_work' => getDropdown(Enum::CONFIG_DROPDOWN_ENTITLEMENT_TO_WORK)[0],
        ];
        // Employee::create($employee_data);

        // $address_data = [
        //     'user_id'               => $user->id,
        //     'operator_id'           => $user->id,
        //     'home_street_address'   => '204 Free School Street',
        //     'home_suburb'           => 'Dhaka',
        //     'home_city'             => 'Dhaka',
        //     'home_post_code'        => '1205',
        //     'postal_street_address' => '204 Free School Street',
        //     'postal_suburb'         => 'Dhaka',
        //     'postal_city'           => 'Dhaka',
        //     'postal_post_code'      => '1205',
        // ];
        // Address::create($address_data);

        // $emergency_contact = [
        //     'user_id'       => $user->id,
        //     'created_by'    => $user->id,
        //     'name'          => 'Dipu Khan',
        //     'mobile_number' => '+64-01843578987',
        //     'relationship'  => 'Brother',
        // ];

        // EmergencyContact::create($emergency_contact);
    }
}
