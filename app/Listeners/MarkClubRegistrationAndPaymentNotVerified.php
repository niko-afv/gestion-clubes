<?php

namespace App\Listeners;

use App\Events\PaymentNotVerifiedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkClubRegistrationAndPaymentNotVerified
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
    public function handle(PaymentNotVerifiedEvent $event)
    {
        $invoice = $event->getObject();
        $invoice->participation->unfinish();
    }
}
