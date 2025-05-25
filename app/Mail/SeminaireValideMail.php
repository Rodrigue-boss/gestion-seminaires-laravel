<?php

namespace App\Mail;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeminaireValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seminaire;

    /**
     * Create a new message instance.
     */
    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Votre demande de séminaire a été validée')
                    ->view('emails.seminaire_valide');
    }
}

