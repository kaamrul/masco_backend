<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->user['country_code'] && $this->user['phone']) {
            $mobile = $this->user['country_code'] . '-' . $this->user['phone'];
            $this->merge(['mobile' => $mobile]);
        }

        if ($this->emergencyContact['country_code'] && $this->emergencyContact['mobile_number']) {
            $emergency_mobile = $this->emergencyContact['country_code'] . '-' . $this->emergencyContact['mobile_number'];
            $this->merge(['emergency_mobile' => $emergency_mobile]);
        }

        if ($this->user['dob']) {
            $this->merge([
                'dob' => prepareDateValidate($this->user['dob'])
            ]);
        }
    }

    public function rules()
    {
        return [

            // All Data For User Table
            //'user.user_type' => ['required', 'string', 'max:255'],
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name'  => ['required', 'string', 'max:255'],
            'user.email'      => ['required', 'string', 'max:255'],
            'user.password'   => ['required', 'string', 'min:8', 'confirmed'],
            'mobile'          => ['required', 'phone_number', 'string', 'max:18'],
            'dob'             => ['required', 'date'],
            'user.gender'     => ['required', 'string', 'max:255'],
            'user.ethnicity'  => ['nullable', 'string', 'max:255'],
            'user.location'   => ['nullable', 'string', 'max:255'],
            'user.avatar'     => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],

            // All Data For Employee Table
            'employee.job_title'           => ['required', 'string', 'max:255'],
            'employee.employment_type'     => ['required', 'string', 'max:255'],
            'employee.entitlement_to_work' => ['required', 'string', 'max:255'],

            // All Data for Address Table
            'address.home_street_address'   => ['required', 'string', 'max:255'],
            'address.home_suburb'           => ['required', 'string', 'max:255'],
            'address.home_city'             => ['required', 'string', 'max:255'],
            'address.home_post_code'        => ['required', 'string', 'max:10'],
            'address.home_latitude'         => ['nullable', 'string', 'max:255'],
            'address.home_longitude'        => ['nullable', 'string', 'max:255'],
            'address.postal_street_address' => ['required', 'string', 'max:255'],
            'address.postal_suburb'         => ['required', 'string', 'max:255'],
            'address.postal_city'           => ['required', 'string', 'max:255'],
            'address.postal_post_code'      => ['required', 'string', 'max:10'],
            'address.postal_latitude'       => ['nullable', 'string', 'max:255'],
            'address.postal_longitude'      => ['nullable', 'string', 'max:255'],

            // All Data for Emergency Contact Table
            'emergencyContact.name'         => ['required', 'string', 'max:255'],
            'emergencyContact.email'        => ['nullable', 'string', 'max:255'],
            'emergency_mobile'              => ['required', 'phone_number', 'string', 'max:18'],
            'emergencyContact.relationship' => ['required', 'string', 'max:255'],
            'emergencyContact.address'      => ['nullable', 'string', 'max:255'],
            'emergencyContact.note'         => ['nullable', 'string', 'max:255'],

            'branch.branch_id' => ['required', 'integer'],

            // Role
            'role_id' => ['nullable', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'mobile.phone_number'           => 'Only numbers (0-9) are allowed',
            'emergency_mobile.phone_number' => 'Only numbers (0-9) are allowed',
            // 'role_id'                       => 'Role is required',
        ];
    }
}
