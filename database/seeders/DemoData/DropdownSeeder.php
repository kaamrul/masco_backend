<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Config;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    public function run()
    {
        $records = self::getRecords();

        foreach ($records as $record) {
            $values = getDropdown($record['dropdown']);
            $values[] = $record['name'];
            self::updateConfig($record['dropdown'], json_encode($values, true));
        }
    }

    private static function getRecords()
    {
        return [

            /*CONFIG_DROPDOWN_TICKET_DEPARTMENT*/
            [
                'name'     => 'Customer Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],
            [
                'name'     => 'On Field Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],
            [
                'name'     => 'Accounts Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],

            /*CONFIG_DROPDOWN_NOTIFICATION_TYPE*/
            [
                'name'     => 'Weekly Announcement',
                'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            ],
            [
                'name'     => 'Monthly Announcement',
                'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            ],
            [
                'name'     => 'Daily Announcement',
                'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            ],

            /*CONFIG_DROPDOWN_GENDER*/
            [
                'name'     => 'Male',
                'dropdown' => Enum::CONFIG_DROPDOWN_GENDER,
            ],
            [
                'name'     => 'Female',
                'dropdown' => Enum::CONFIG_DROPDOWN_GENDER,
            ],
            [
                'name'     => 'Others',
                'dropdown' => Enum::CONFIG_DROPDOWN_GENDER,
            ],

            /*CONFIG_DROPDOWN_EMPLOYMENT_STATUS*/
            [
                'name'     => 'Part-Time',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS,
            ],
            [
                'name'     => 'Full Time',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS,
            ],
            [
                'name'     => 'Contractual',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS,
            ],
            [
                'name'     => 'Fix Term Full',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS,
            ],

            /*CONFIG_DROPDOWN_JOB_TITLE*/
            [
                'name'     => 'HR',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],
            [
                'name'     => 'Frontend Developer',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],
            [
                'name'     => 'Banckend Developer',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],
            [
                'name'     => 'FullStack Developer',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],

            /* CONFIG_DROPDOWN_CERTIFICATION_TYPE */
            [
                'name'     => 'Social Initiatives Audits',
                'dropdown' => Enum::CONFIG_DROPDOWN_CERTIFICATION_TYPE,
            ],
            [
                'name'     => 'Environmental Initiatives Audits',
                'dropdown' => Enum::CONFIG_DROPDOWN_CERTIFICATION_TYPE,
            ],
            [
                'name'     => 'Eco Certifications',
                'dropdown' => Enum::CONFIG_DROPDOWN_CERTIFICATION_TYPE,
            ],
            [
                'name'     => 'Chemical Initiatives/Audits',
                'dropdown' => Enum::CONFIG_DROPDOWN_CERTIFICATION_TYPE,
            ],
        ];
    }

    private static function updateConfig(string $key, string $value)
    {
        $config = Config::firstOrNew(['key' => $key]);
        $config->value = $value;
        $config->save();
    }
}
