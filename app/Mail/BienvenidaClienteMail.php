<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BienvenidaClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $verificationUrl;

    /**
     * Crea una nueva instancia del mensaje.
     */
    public function __construct($user, $password, $verificationUrl = null)
    {
        $this->user = $user;
        $this->password = $password;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Obtiene el sobre (envelope) del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenida Cliente Mail',
        );
    }

    /**
     * Obtiene la definición del contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bienvenida_cliente',
        );
    }

    /**
     * Obtiene los archivos adjuntos para el mensaje.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
