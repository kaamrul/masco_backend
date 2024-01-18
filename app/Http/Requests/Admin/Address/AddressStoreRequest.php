<?php

namespace App\Http\Requests\Admin\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id'               => ['required', 'integer'],
            'home_street_address'   => ['required', 'string', 'max:255'],
            'home_suburb'           => ['required', 'string', 'max:255'],
            'home_city'             => ['required', 'string', 'max:255'],
            'home_post_code'        => ['required', 'integer'],
            'home_latitude'         => ['required', 'string', 'max:255'],
            'home_longitude'        => ['required', 'string', 'max:255'],
            'postal_street_address' => ['required', 'string', 'max:255'],
            'postal_suburb'         => ['required', 'string', 'max:255'],
            'postal_city'           => ['required', 'string', 'max:255'],
            'postal_post_code'      => ['required', 'integer'],
            'postal_latitude'       => ['required', 'string'],
            'postal_longitude'      => ['required', 'string'],
            'operator_id'           => ['required', 'integer'],
        ];
    }
}
