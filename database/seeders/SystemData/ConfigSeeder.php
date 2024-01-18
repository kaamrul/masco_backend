<?php

namespace Database\Seeders\SystemData;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // General Settings
            ['key' => 'app_title', 'value' => 'Masco Group'],
            ['key' => 'admin_prefix', 'value' => 'admin'],
            ['key' => 'version', 'value' => 'V-1.0'],
            ['key' => 'copyright', 'value' => ''],
            ['key' => 'copyright_url', 'value' => ''],
            ['key' => 'website', 'value' => ''],

            // Communication
            ['key' => 'country_code', 'value' => ''],
            ['key' => 'phone', 'value' => ''],
            ['key' => 'email', 'value' => ''],
            // ['key' => 'ticket_email', 'value' => ''],

            // Address
            ['key' => 'city', 'value' => ''],
            ['key' => 'state', 'value' => ''],
            ['key' => 'zip_code', 'value' => ''],
            ['key' => 'country', 'value' => ''],
            ['key' => 'address', 'value' => ''],

            // Multimedia
            ['key' => 'logo', 'value' => ''],
            ['key' => 'favicon', 'value' => ''],
            ['key' => 'og_image', 'value' => ''],
            ['key' => 'login_logo', 'value' => ''],
            ['key' => 'login_bg_image', 'value' => ''],

            // Date & Time
            ['key' => 'system_launch_date', 'value' => '2023-01-01'],
            ['key' => 'date_format', 'value' => 'DD-MM-YYYY'],
            ['key' => 'time_format', 'value' => '24h'],
            ['key' => 'app_timezone', 'value' => 'Asia/Dhaka'],

            // Currency
            ['key' => 'currency_name', 'value' => 'Dollar'],
            ['key' => 'currency_symbol', 'value' => '$'],
            ['key' => 'number_of_decimal', 'value' => '2'],
            ['key' => 'currency_position', 'value' => ''],
            ['key' => 'decimal_separator', 'value' => '.'],
            ['key' => 'thousand_separator', 'value' => ''],

            // Email Settings
            ['key' => 'mail_mailer', 'value' => 'smtp'],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com'],
            ['key' => 'mail_port', 'value' => '587'],
            ['key' => 'mail_username', 'value' => ''],
            ['key' => 'mail_password', 'value' => ''],
            ['key' => 'mail_from_address', 'value' => 'hello@example.com'],
            ['key' => 'mail_from_name', 'value' => 'You App Name'],
            ['key' => 'mail_encryption', 'value' => 'tls'],

            // Social Link Share
            ['key' => 'facebook_link', 'value' => '#'],
            ['key' => 'twitter_link', 'value' => '#'],
            ['key' => 'instagram_link', 'value' => '#'],
            ['key' => 'linkedin_link', 'value' => '#'],
            ['key' => 'youtube_link', 'value' => '#'],
        ];

        Config::insert($data);
    }
}
