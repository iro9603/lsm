<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventoAgendadoMail extends Mailable
{
    use Queueable, SerializesModels;



    public $meetLink;

    /**
     * Create a new message instance.
     */
    public function __construct($meetLink)
    {

        $this->meetLink = $meetLink;
    }

    public function build()
    {
        return $this->subject('Reunión Agendada')
            ->view('emails.evento-meet');
    }




}
