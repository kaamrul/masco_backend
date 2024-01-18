<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->country_code && $this->phone) {
            $phone = $this->country_code . '-' . $this->phone;
            $this->merge(['phone' => $phone]);
        }

        // System Details Validation
        if ($this->system_details) {
            $systemDetails = $this->system_details;
            $this->merge(['system_details' => $systemDetails]);
        }

        // System Details Validation
        if ($this->communication) {
            $communication = $this->communication;
            $this->merge(['communication' => $communication]);
        }

        // Time & Date Validation
        if ($this->dateTime) {
            $dateTime = $this->dateTime;
            $this->merge(['dateTime' => $dateTime]);
        }

        // Currency Validation
        if ($this->currency) {
            $currency = $this->currency;
            $this->merge(['currency' => $currency]);
        }
    }

    public function rules()
    {
        return [
            // System Details
            'app_title'     => ['required_with:systemDetails', 'string', 'max:255'],
            'version'       => ['nullable', 'string', 'max:255'],
            'copyright'     => ['nullable', 'string', 'max:255'],
            'copyright_url' => ['nullable', 'string', 'max:255'],
            'website'       => ['nullable', 'string'],

            // Address
            'state'    => ['nullable', 'string', 'max:255'],
            'city'     => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'country'  => ['nullable', 'string', 'max:30'],
            'address'  => ['nullable', 'string', 'max:255'],

            // Communication
            'country_code' => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'phone_number', 'string', 'max:255'],
            'email'        => ['required_with:communication', 'string', 'max:255'],
            'ticket_email' => ['nullable', 'string', 'max:255'],

            // Multimedia
            'logo'           => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'favicon'        => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif,JPEG'],
            'og_image'       => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'login_logo'     => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'login_bg_image' => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],

            // Time Zone
            'date_format'  => ['required_with:dateTime', 'string', 'max:255'],
            'time_format'  => ['required_with:dateTime', 'string', 'max:255'],
            'app_timezone' => ['required_with:dateTime', 'string', 'max:255'],

            // Currency
            'currency_name'      => ['nullable', 'string', 'max:25'],
            'currency_symbol'    => ['required_with:currency', 'string', 'max:25'],
            'currency_position'  => ['nullable', 'string', 'max:255'],
            'decimal_separator'  => ['nullable', 'string', 'max:255'],
            'thousand_separator' => ['nullable', 'string', 'max:255'],
            'number_of_decimal'  => ['nullable', 'string', 'max:255'],

            // POS
            'invoice_prefix'     => ['nullable', 'string', 'max:255'],
            'invoice_start_from' => ['nullable', 'string', 'max:255'],
            'sku_prefix'         => ['nullable', 'string', 'max:255'],
            'barcode_prefix'     => ['nullable', 'string', 'max:255'],
            'low_stock_alert'    => ['nullable', 'numeric'],
            'vat_amount'         => ['nullable', 'numeric'],
            'notification_time'  => ['nullable', 'string', 'max:255'],
            'invoice_logo'       => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone_number' => 'Only numbers (0-9) are allowed.',
            'app_title'          => 'App Title fields is required.',
            'email'              => 'The email field is required.',
            'date_format'        => 'The date format field is required.',
            'time_format'        => 'The time format field is required.',
            'app_timezone'       => 'The time zone field is required.',
            'currency_symbol'    => 'The currency symbol field is required.',
        ];
    }
}
