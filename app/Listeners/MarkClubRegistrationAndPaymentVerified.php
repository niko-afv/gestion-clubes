<?php

namespace App\Listeners;

use App\Events\PaymentVerifiedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkClubRegistrationAndPaymentVerified
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
    public function handle(PaymentVerifiedEvent $event)
    {
        $payment = $event->getObject();
        $payment->invoice->markAsPaid();
        $payment->invoice->participation->finish();
    }
}
