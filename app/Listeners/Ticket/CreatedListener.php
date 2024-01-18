<?php

namespace App\Listeners\Ticket;

use App\Events\Ticket\CreatedEvent;
use App\Models\EmailTemplate;
use App\Models\Ticket;
use App\Library\Enum;
use App\Library\Helper;
use App\Library\Services\Admin\EmailService;

class CreatedListener
{
    public function __construct()
    {

    }

    public function handle(CreatedEvent $event)
    {
        $this->sendEmailNotification($event->ticket);

    }

    private function sendEmailNotification(Ticket $ticket)
    {
        $email_setting = EmailTemplate::where('key', Enum::EMAIL_TICKET_CREATE)->first();

        $subject = $email_setting->subject;
        $message = $email_setting->message;
        $ticket_user = $ticket->user;

        $shortcodes = explode(',', $email_setting->shortcodes);
        $shortcode_values = [];

        foreach ($shortcodes as $shortcode) {
            switch ($shortcode) {
                case 'receiver_name':
                    $shortcode_values['receiver_name'] = $ticket_user->full_name;

                    break;
                case 'ticket_id':
                    $shortcode_values['ticket_id'] = $ticket->id;

                    break;
                case 'reply_message':
                    $shortcode_values['reply_message'] = $ticket->message;

                    break;
                default:
            }
        }

        $message = Helper::replaceMessageWithShortcodes($message, $shortcode_values);

        $data = [
            'user_id'      => $ticket_user->id,
            'email'        => $ticket_user->email,
            'subject'      => $subject,
            'message'      => $message,
            'ticket_email' => settings('ticket_email'),
        ];

        EmailService::sendMail($data);

    }
}
