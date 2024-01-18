<?php

use App\Models\Order;
use App\Models\Config;
use App\Models\Location;
use Illuminate\Support\Arr;
use Rmunate\Utilities\SpellNumber;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Library\Services\Admin\ConfigService;

/**
 * Fetch config data by key
 *
 * @param  $key
 *
 * @return mixed
 */
function settings($key)
{
    // static $config;

    // if (is_null($config)) {
    //     $config = Cache::remember('config', 24 * 60, function () {
    //         return Config::pluck('value', 'key')->toArray();
    //     });
    // }

    $config = Config::pluck('value', 'key')->toArray();

    return (is_array($key)) ? Arr::only($config, $key) : $config[$key];
}

/**
 * Update env file
 *
 * @param  $data - key value pair data
 *  key is the key of env file
 *  and the value is associated value of the key
 *
 * @return mixed
 */
function updateEnv(array $data)
{
    foreach ($data as $key => $value) {
        $key = strtoupper($key);
        $updatedEnvData = str_replace($key . '="' . env($key) . '"', $key . '="' . $value . '"', file_get_contents(app()->environmentFilePath()));

        file_put_contents(app()->environmentFilePath(), $updatedEnvData);
    }
}

/**
 * Delete file
 *
 * @param  $path
 *
 * @return void
 */
function deleteFile($path)
{
    $paths = is_array($path) ? $path : [$path];

    foreach ($paths as $item) {
        if (File::exists(public_path($item))) {
            File::delete(public_path($item));
        }
    }
}

/**
 *
 * @param  $key
 *
 * @return mixed
 */
function getDropdown(string $key)
{
    return ConfigService::getDropdown($key);
}

function getLocations()
{
    return Location::orderBy('name')->get();
}

function formatPrice($price)
{
    // Format the price with 2 decimal places and a comma as the thousands separator
    $formattedPrice = number_format($price, 2, '.', ',');

    // Add a dollar sign to the beginning of the formatted price
    $formattedPrice = settings('currency_symbol') != '' ? settings('currency_symbol') . $formattedPrice : config('app.currency_sign') . $formattedPrice;

    return $formattedPrice;
}

function getFormattedAmount($amount)
{
    $symbol = settings('currency_symbol') ? settings('currency_symbol') : '$';
    $position = settings('currency_position') ? settings('currency_position') : "left";
    $decimalSeparator = settings('decimal_separator') ? settings('decimal_separator') : '.';
    $thousandSeparator = settings('thousand_separator') ? settings('thousand_separator') : 'comma';
    $numberOfDecimal = settings('number_of_decimal') ? settings('number_of_decimal') : '0';

    if ($thousandSeparator == 'comma') {
        $thousandSeparator = ',';
    } else {
        $thousandSeparator = ' ';
    }

    $formattedAmount = number_format($amount, $numberOfDecimal, $decimalSeparator, $thousandSeparator);

    // set currency position
    if ($position == 'left') {
        $formattedAmount = $symbol . $formattedAmount;
    } else {
        $formattedAmount = $formattedAmount . $symbol;
    }

    return $formattedAmount;
}

function generateInvoiceId()
{
    $invoice_prefix = settings('invoice_prefix') ? settings('invoice_prefix') : '';
    $invoice_start_from = settings('invoice_start_from') ? settings('invoice_start_from') : 0; //1000

    // $order = Order::latest()->first();
    $order = Order::orderBy('id', 'desc')->first();

    if ($order) {
        return $invoice_prefix ? ($invoice_prefix . '-' . ($order->id + 1) + abs($invoice_start_from)) : ($order->id + 1 + abs($invoice_start_from));
    }

    return $invoice_prefix ? ($invoice_prefix . '-' . abs($invoice_start_from) + 1) : (abs($invoice_start_from) + 1);
}

function generateQuotationId()
{
    $invoice_prefix = settings('invoice_prefix') ? settings('invoice_prefix') : '';
    $invoice_start_from = settings('invoice_start_from') ? settings('invoice_start_from') : 0; //1000

   // $order = Order::latest()->first();
    $order = Order::orderBy('id', 'desc')->first();

    if ($order) {
        return $invoice_prefix ? ($invoice_prefix . '-' . ($order->id + 1) + abs($invoice_start_from)) : ($order->id + 1 + abs($invoice_start_from));
    }

    return $invoice_prefix ? ($invoice_prefix . '-' . abs($invoice_start_from) + 1) : (abs($invoice_start_from) + 1);
}

function authId()
{
    return auth()->id();
}

function authUser()
{
    return auth()->user();
}

function getCompanyAddress()
{
    $fullAddress = '';

    if(settings('address') && settings('address') != '') {
        $fullAddress .= settings('address') . ',';
    }

    if(settings('state') && settings('state') != '') {
        $fullAddress .= settings('state') . ', ';
    }

    if(settings('city') && settings('city') != '') {
        $fullAddress .= settings('city') . ', ';
    }

    if(settings('country') && settings('country') != '') {
        $fullAddress .= settings('country') . ', ';
    }

    if(settings('zip_code') && settings('zip_code') != '') {
        $fullAddress .= settings('zip_code') . '.';
    }

    return $fullAddress;
}

function numberToWord($number = 0)
{
    return ucwords(SpellNumber::value($number)->toLetters());
}