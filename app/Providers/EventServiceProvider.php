<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Location;
use App\Models\TicketReply;
use App\Models\Notification;
use App\Models\TicketAssign;
use App\Models\EmailTemplate;
use App\Observers\UserObserver;
use App\Events\Auth\LoggedEvent;
use App\Observers\TicketObserver;
use App\Events\Ticket\CreatedEvent;
use App\Events\Ticket\RepliedEvent;
use App\Observers\EmployeeObserver;
use App\Observers\LocationObserver;
use App\Events\Ticket\AssignedEvent;
use App\Listeners\Auth\LoggedListener;
use App\Observers\TicketReplyObserver;
use App\Observers\NotificationObserver;
use App\Observers\TicketAssignObserver;
use App\Events\Notification\CreateEvent;
use App\Events\Notification\DeleteEvent;
use App\Observers\EmailTemplateObserver;
use App\Listeners\Ticket\CreatedListener;
use App\Listeners\Ticket\RepliedListener;
use App\Listeners\Ticket\AssignedListener;
use App\Listeners\Notification\CreateListener;
use App\Listeners\Notification\DeleteListener;
use App\Http\Requests\Admin\Ticket\CreateRequest;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        /*
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        */
        LoggedEvent::class => [
            LoggedListener::class
        ],
        //Notification Create Event
        CreateEvent::class => [
            CreateListener::class
        ],
        //Notification Delete Event
        DeleteEvent::class => [
            DeleteListener::class
        ],

        CreateRequest::class => [
            CreatedListener::class
        ],
        //Ticket Events Start
        AssignedEvent::class => [
            AssignedListener::class
        ],

        CreatedEvent::class => [
            CreatedListener::class
        ],

        RepliedEvent::class => [
            RepliedListener::class
        ],
        //Ticket Events End

    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        User::class => [UserObserver::class],
        // Role::class                 => [RoleObserver::class],
        // Permission::class           => [PermissionObserver::class],
        Ticket::class        => [TicketObserver::class],
        Employee::class      => [EmployeeObserver::class],
        EmailTemplate::class => [EmailTemplateObserver::class],
        TicketAssign::class  => [TicketAssignObserver::class],
        TicketReply::class   => [TicketReplyObserver::class],
        Notification::class  => [NotificationObserver::class],
        Location::class      => [LocationObserver::class],
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
