<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $pdfPath;

    public function __construct($order, $user, $pdfPath)
    {
        $this->order = $order;
        $this->user = $user;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Tu factura de Bodyquick')
            ->markdown('emails.factura_cliente')
            ->with([
                'order' => $this->order,
                'user' => $this->user,
            ])
            ->attach(storage_path('app/public/' . $this->pdfPath), [
                'as' => 'Factura_Bodyquick.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
