<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->user['country_code'] && $this->user['phone']) {
            $mobile = $this->user['country_code'] . '-' . $this->user['phone'] ;
            $this->merge(['mobile' => $mobile]);
        }
    }

    public function rules()
    {
        return [
            // All Data For User Table
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.m_name'     => ['nullable', 'string', 'max:255'],
            'user.last_name'  => ['required', 'string', 'max:255'],
            'user.email'      => ['required', 'string', 'max:255'],
            'mobile'          => ['required', 'phone_number', 'string'],
            'user.dob'        => ['required', 'string', 'max:255'],
            'user.gender'     => ['required', 'string', 'max:255'],
            'user.ethnicity'  => ['required', 'string', 'max:255'],
            'user.location'   => ['required', 'string', 'max:255'],

            'user.avatar' => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],

            // All Data for Address Table
            'address.home_street_address' => ['required', 'string', 'max:255'],
            'address.home_suburb'         => ['required', 'string', 'max:255'],
            'address.home_city'           => ['required', 'string', 'max:255'],
            'address.home_post_code'      => ['required', 'integer'],
            'address.home_latitude'       => ['nullable', 'string', 'max:255'],
            'address.home_longitude'      => ['nullable', 'string', 'max:255'],

            'address.postal_street_address' => ['required', 'string', 'max:255'],
            'address.postal_suburb'         => ['required', 'string', 'max:255'],
            'address.postal_city'           => ['required', 'string', 'max:255'],
            'address.postal_post_code'      => ['required', 'integer'],
            'address.postal_latitude'       => ['nullable', 'string', 'max:255'],
            'address.postal_longitude'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'mobile.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
