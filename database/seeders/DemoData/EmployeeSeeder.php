<?php

namespace Database\Seeders\DemoData;

use App\Models\User;
use App\Library\Enum;
use App\Models\Branch;
use App\Models\Address;
use App\Models\Employee;
use App\Models\EmployeeBranch;
use Illuminate\Database\Seeder;
use App\Models\EmergencyContact;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Employee-1
        $user_data = [
            'first_name'  => 'Kamrul',
            'last_name'   => 'Hasan',
            'email'       => 'kamrul@employee.com',
            'password'    => bcrypt(12345678),
            'phone'       => '+64-0184456892',
            'operator_id' => 1,
            'dob'         => '1999-02-01',
            'gender'      => getDropdown(Enum::CONFIG_DROPDOWN_GENDER)[0],
            'user_type'   => Enum::USER_TYPE_EMPLOYEE,
            'status'      => Enum::STATUS_ACTIVE
        ];

        $user = User::create($user_data);
        // $user->roles()->attach(2);
        $employee_data = [
            'user_id'             => $user->id,
            'operator_id'         => 1,
            'job_title'           => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE)[0],
            'employment_type'     => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS)[0],
        ];

        $employee = Employee::create($employee_data);

        $address = [
            'user_id'             => $user->id,
            'operator_id'         => 1,
            'home_street_address' => '204 Free School Street',
            'home_suburb'         => 'Dhaka',
            'home_city'           => 'Dhaka',
            'home_post_code'      => 1205,

            'postal_street_address' => '204 Free School Street',
            'postal_suburb'         => 'Dhaka',
            'postal_city'           => 'Dhaka',
            'postal_post_code'      => 1205,
        ];
        Address::create($address);

        $emergency_contact = [
            'user_id'       => $user->id,
            'created_by'    => 1,
            'name'          => 'Jalal',
            'mobile_number' => '+64-018464565',
            'relationship'  => 'Brother',
        ];
        EmergencyContact::create($emergency_contact);

        // ============  Employee-2  =================//
        $user_data2 = [
            'first_name'  => 'Sojib',
            'last_name'   => 'Hossain',
            'email'       => 'shojib@employee.com',
            'password'    => bcrypt(12345678),
            'phone'       => '+64-0184564545',
            'operator_id' => 1,
            'dob'         => '1999-02-01',
            'gender'      => getDropdown(Enum::CONFIG_DROPDOWN_GENDER)[0],
            'user_type'   => Enum::USER_TYPE_EMPLOYEE,
            'status'      => Enum::STATUS_ACTIVE
        ];

        $user2 = User::create($user_data2);
        // $user2->roles()->attach(2);
        $employee_data2 = [
            'user_id'             => $user2->id,
            'operator_id'         => 1,
            'job_title'           => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE)[0],
            'employment_type'     => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS)[0],
        ];

        $employee2 = Employee::create($employee_data2);

        $address2 = [
            'user_id'             => $user2->id,
            'operator_id'         => 1,
            'home_street_address' => '204 Free School Street',
            'home_suburb'         => 'Dhaka',
            'home_city'           => 'Dhaka',
            'home_post_code'      => 1205,

            'postal_street_address' => '204 Free School Street',
            'postal_suburb'         => 'Dhaka',
            'postal_city'           => 'Dhaka',
            'postal_post_code'      => 1205,
        ];
        Address::create($address2);

        $emergency_contact2 = [
            'user_id'       => $user2->id,
            'created_by'    => 1,
            'name'          => 'Dipu Khan',
            'mobile_number' => '+64-01843578987',
            'relationship'  => 'Brother',
        ];
        EmergencyContact::create($emergency_contact2);

        //Employee-3
        $user_data3 = [
            'first_name'      => 'Mofiz',
            'last_name'      => 'Islam',
            'email'       => 'mofiz@employee.com',
            'password'    => bcrypt(12345678),
            'phone'       => '+64-01866898',
            'operator_id' => 1,
            'dob'         => '1999-02-01',
            'gender'      => getDropdown(Enum::CONFIG_DROPDOWN_GENDER)[0],
            'user_type'   => Enum::USER_TYPE_EMPLOYEE,
        ];

        $user3 = User::create($user_data3);
        // $user3->roles()->attach(2);
        $employee_data3 = [
            'user_id'             => $user3->id,
            'operator_id'         => 1,
            'job_title'           => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE)[0],
            'employment_type'     => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS)[0],
        ];

        $employee3 = Employee::create($employee_data3);

        $address3 = [
            'user_id'             => $user3->id,
            'operator_id'         => 1,
            'home_street_address' => '204 Free School Street',
            'home_suburb'         => 'Dhaka',
            'home_city'           => 'Dhaka',
            'home_post_code'      => 1205,

            'postal_street_address' => '204 Free School Street',
            'postal_suburb'         => 'Dhaka',
            'postal_city'           => 'Dhaka',
            'postal_post_code'      => 1205,
        ];
        Address::create($address3);

        $emergency_contact3 = [
            'user_id'       => $user3->id,
            'created_by'    => 1,
            'name'          => 'Rashed Khan',
            'mobile_number' => '+64-01843546578',
            'relationship'  => 'Brother',
        ];
        EmergencyContact::create($emergency_contact3);
    }
}
