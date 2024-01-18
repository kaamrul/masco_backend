<?php

namespace App\Http\Requests\Admin\Location;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
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
            'name'    => ['required', 'string', 'max:255', 'unique:locations'],
            'ip'      => ['nullable', 'string', 'max:255', 'unique:locations'],
            'details' => ['nullable', 'string'],
        ];
    }
}
