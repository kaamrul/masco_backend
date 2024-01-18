<?php

namespace Database\Seeders\DemoData;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = self::getRecords();

        foreach($records as $value) {
            $notification = new Notification();
            $notification->is_for_emp = $value['is_for_emp'];
            $notification->subject = $value['subject'];
            $notification->message = $value['message'];
            $notification->user_id = 1;
            $notification->send_date = $value['send_date'];
            $notification->save();
        }
    }

    private static function getRecords()
    {
        return [
            [
                'subject'       => 'For Employment Period',
                'is_for_emp'    => 1,
                'message'       => 'The Employee agrees that during the Employment Period, he/she shall devote his/her full business time to the business affairs of the Company and shall perform the duties assigned to him/her faithfully and efficiently.',
                'send_date'     => date('Y-m-d', strtotime("+10 days")),
            ],

            [
                'subject'       => 'Contractual agreement',
                'is_for_emp'    => 0,
                'message'       => 'A contractual agreement, also known as a contract, outlines, defines, and governs all of the rights and duties between the parties involved.',
                'send_date'     => date('Y-m-d', strtotime("+20 days")),
            ],

            [
                'subject'       => 'For legal document',
                'is_for_emp'    => 0,
                'message'       => 'As stated above, a contract is a legal document. In its simplest terms, it is a statement of an agreement between or among two or more parties that involves an exchange of value. There may be money involved, or there may be an exchange of goods, services, space, or some other commodity. If theres an agreement to provide something in return for something else, its considered a contract.',
                'send_date'     => date('Y-m-d', strtotime("+30 days")),
            ],
        ];
    }
}
