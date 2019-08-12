<?php

namespace App\Providers;

use App\Events\ActivatedEventEvent;
use App\Events\ActivatedUserEvent;
use App\Events\AddedMemberEvent;
use App\Events\AddedUserEvent;
use App\Events\CreatedEventEvent;
use App\Events\CreatedUnitEvent;
use App\Events\DeactivatedEventEvent;
use App\Events\DeactivatedUserEvent;
use App\Events\DeletedEventEvent;
use App\Events\DeletedMemberEvent;
use App\Events\DeletedUnitEvent;
use App\Events\ImportedMembersEvent;
use App\Events\LoginEvent;
use App\Events\UpdatedEventEvent;
use App\Events\UpdatedMemberEvent;
use App\Events\UpdatedUnitEvent;
use App\Listeners\LogEventsListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoginEvent::class => [
            LogEventsListener::class,
        ],
        AddedMemberEvent::class => [
            LogEventsListener::class,
        ],
        UpdatedMemberEvent::class => [
            LogEventsListener::class,
        ],
        DeletedMemberEvent::class => [
            LogEventsListener::class,
        ],
        ImportedMembersEvent::class => [
            LogEventsListener::class,
        ],
        CreatedUnitEvent::class => [
            LogEventsListener::class,
        ],
        UpdatedUnitEvent::class => [
            LogEventsListener::class,
        ],
        DeletedUnitEvent::class => [
            LogEventsListener::class,
        ],
        CreatedEventEvent::class => [
            LogEventsListener::class,
        ],
        UpdatedEventEvent::class => [
            LogEventsListener::class,
        ],
        DeletedEventEvent::class => [
            LogEventsListener::class,
        ],
        ActivatedEventEvent::class => [
            LogEventsListener::class,
        ],
        DeactivatedEventEvent::class => [
            LogEventsListener::class,
        ],
        ActivatedUserEvent::class => [
            LogEventsListener::class,
        ],
        DeactivatedUserEvent::class => [
            LogEventsListener::class,
        ],
        AddedUserEvent::class => [
            LogEventsListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
