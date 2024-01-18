<?php

namespace App\Http\Requests\Admin\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['operator_id' => auth()->id()]);
    }
    public function rules(): array
    {
        return [
            'home_street_address'   => ['required', 'string', 'max:255'],
            'home_suburb'           => ['required', 'string', 'max:255'],
            'home_city'             => ['required', 'string', 'max:255'],
            'home_post_code'        => ['required', 'integer'],
            'home_latitude'         => ['nullable', 'string', 'max:255'],
            'home_longitude'        => ['nullable', 'string', 'max:255'],
            'postal_street_address' => ['required', 'string', 'max:255'],
            'postal_suburb'         => ['required', 'string', 'max:255'],
            'postal_city'           => ['required', 'string', 'max:255'],
            'postal_post_code'      => ['required', 'integer'],
            'postal_latitude'       => ['nullable', 'string'],
            'postal_longitude'      => ['nullable', 'string'],
            'operator_id'           => ['required', 'integer'],
        ];
    }
}
