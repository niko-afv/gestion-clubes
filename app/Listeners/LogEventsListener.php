<?php

namespace App\Listeners;

use App\Contracts\ILog;
use App\Events\LoginEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogEventsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ILog $event)
    {
        Auth::user()->logs()->create([
            'log_type_id' => $event->getTipoLog(),
            'loggable_type' => get_class($event->getObject()),
            'loggable_id' => $event->getObject()->id
        ]);
    }
}
