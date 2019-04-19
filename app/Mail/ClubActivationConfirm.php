<?php

namespace App\Mail;

use App\Club;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClubActivationConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $club;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Club $club)
    {
        $this->club = $club;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.clubActivationConfirm')
            ->subject('Conquistadores AMCH | Activar Club')
            ->from('conquistadoresamch@gmail.com')
            ->to($this->club->director->email)
            ;
    }
}
