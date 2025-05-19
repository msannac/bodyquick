<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaAnuladaClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $cita;
    public $actividad;

    /**
     * Crea una nueva instancia del mensaje.
     */
    public function __construct($reserva, $cita, $actividad)
    {
        $this->reserva = $reserva;
        $this->cita = $cita;
        $this->actividad = $actividad;
    }

    /**
     * Obtiene el sobre (envelope) del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reserva anulada en Bodyquick',
        );
    }

    /**
     * Obtiene la definición del contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reserva_anulada_cliente',
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
