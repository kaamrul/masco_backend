<?php

namespace Database\Seeders\SystemData;

use App\Library\Enum;
use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = self::getRecords();

        foreach ($records as $record) {
            EmailTemplate::create($record);
        }
    }

    private static function getRecords()
    {
        return [
            //=====--- Ticket --=========//
            [
                'name'       => 'Ticket Created',
                'key'        => Enum::EMAIL_TICKET_CREATE,
                'subject'    => 'You have been opened a ticket',
                'message'    => self::getContent(Enum::EMAIL_TICKET_CREATE),
                'shortcodes' => 'receiver_name,ticket_id,reply_message',
            ],
            [
                'name'       => 'Ticket Assigned',
                'key'        => Enum::EMAIL_TICKET_ASSIGN,
                'subject'    => 'You have been Assigned To a ticket',
                'message'    => self::getContent(Enum::EMAIL_TICKET_ASSIGN),
                'shortcodes' => 'assign_to',
            ],
            [
                'name'       => 'Ticket Replied',
                'key'        => Enum::EMAIL_TICKET_REPLY,
                'subject'    => 'You have been Replied a ticket',
                'message'    => self::getContent(Enum::EMAIL_TICKET_REPLY),
                'shortcodes' => 'reply_message,reply_to',
            ],
            [
                'name'       => 'Job Post Created',
                'key'        => Enum::EMAIL_POST_CREATE,
                'subject'    => 'A new Post is Created for You',
                'message'    => self::getContent(Enum::EMAIL_POST_CREATE),
                'shortcodes' => 'post_type,post_title,email_to',
            ],
        ];
    }

    private static function getContent($key)
    {
        return file_get_contents(__DIR__ . '/emails/' . $key . '.php');
    }
}
