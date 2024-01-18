<?php

namespace App\Http\Requests\Admin\Notification;

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
        if ($this->member_type == 1) {
            if ($this->user_type == null && $this->user_status == null) {
                $this->merge(['select_one_when_member_type_is_general' => true]);
            }
        } else {
            $this->merge(['is_type_tournament' => true]);
        }
    }

    public function rules()
    {
        return [
            'member_type'   => ['nullable', 'integer'],
            'user_type'     => ['nullable', 'required_with:select_one_when_member_type_is_general', 'array'],
            'user_status'   => ['nullable', 'required_with:select_one_when_member_type_is_general', 'array'],
            'tournament'    => ['nullable', 'required_with:is_type_tournament', 'array'],
            'subject'       => ['required', 'string', 'max:255'],
            'is_for_emp'    => ['nullable', 'required_with:is_member_null', 'boolean'],
            'message'       => ['required', 'string', 'max:255'],
            'send_date'     => ['nullable', 'date', 'max:255'],
        ];
    }
}
