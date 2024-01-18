<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Config;
use App\Library\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\Admin\Config\GeneralSettingsRequest;

class GeneralSettingsController extends Controller
{
    public function systemDetails()
    {
        return view('admin.pages.config.general_settings.system_details', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function address()
    {
        return view('admin.pages.config.general_settings.address', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function communication()
    {
        return view('admin.pages.config.general_settings.communication', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function multimedia()
    {
        return view('admin.pages.config.general_settings.media', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function date_time()
    {
        return view('admin.pages.config.general_settings.date_time', [
            'countries' => Helper::getCountries(),
            'timezones' => Helper::getTimeZones(),
        ]);
    }

    public function currency()
    {
        return view('admin.pages.config.general_settings.currency', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function posSettings()
    {
        return view('admin.pages.config.general_settings.pos', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function updateGeneralSettings(GeneralSettingsRequest $request)
    {
        $data = $request->validated();

        if (isset($data['logo'])) {
            $data['logo'] = Helper::uploadImage($data['logo'], Enum::CONFIG_IMAGE_DIR, 300, 50);
        }

        if (isset($data['favicon'])) {
            $data['favicon'] = Helper::uploadImage($data['favicon'], Enum::CONFIG_IMAGE_DIR, 32, 32);
        }

        if (isset($data['og_image'])) {
            $data['og_image'] = Helper::uploadImage($data['og_image'], Enum::CONFIG_IMAGE_DIR, 200, 200);
        }

        if (isset($data['invoice_logo'])) {
            $data['invoice_logo'] = Helper::uploadImage($data['invoice_logo'], Enum::CONFIG_IMAGE_DIR, 200, 200);
        }

        if (isset($data['login_logo'])) {
            $data['login_logo'] = Helper::uploadImage($data['login_logo'], Enum::CONFIG_IMAGE_DIR, 200, 200);
        }

        if (isset($data['login_bg_image'])) {
            $data['login_bg_image'] = Helper::uploadImage($data['login_bg_image'], Enum::CONFIG_IMAGE_DIR, '', '');
        }

        $this->updateConfig($data);

        unset($data['date_format'], $data['time_format']);

        if (isset($data['app_timezone'])) {
            updateEnv($data);
        }

        return back()->with('success', __('Successfully Updated'));
    }

    protected function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            Config::where('key', $key)->update(['value' => $value]);
        }

        Artisan::call('cache:clear');
    }
}
