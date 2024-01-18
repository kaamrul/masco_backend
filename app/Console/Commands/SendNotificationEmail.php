<?php

namespace App\Console\Commands;

use App\Mail\BulkEmail;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to Users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notifications = Notification::where(['send_date' => now()->format('y-m-d')])->get();

        foreach ($notifications->load('recipients') as $notification) {

            $recipients = $notification->recipients->load('user');

            if (count($recipients) > 0) {
                foreach ($recipients as $recipient) {
                    try {
                        Mail::to($recipient->user->email)->send(new BulkEmail($recipient->user?->first_name . ' ' . $recipient->user?->last_name, $notification->subject, $notification->message));

                        $recipient->update(['is_try' => 1, 'is_sent' => 1]);
                    } catch (\Exception $e) {
                        logger($e->getMessage());
                        $recipient->update(['is_try' => 1]);
                    }
                }
            }
        }
    }
}
