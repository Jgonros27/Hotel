<?php

namespace App\Mail;

use App\Models\ReservaCabana;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReservaCabanaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('mail.confirmacion1'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.reservaCabanas.mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $ultimaReserva = ReservaCabana::find($this->data['reservaId']);

        $pdfPath = storage_path('app/reservaCabanas/factura' . $ultimaReserva->id . '.pdf');

        $html = view('admin.reservaCabanas.facturaPdf', ['reservaCabana' => $ultimaReserva])->render();

        $tempHtmlFile = tempnam(sys_get_temp_dir(), 'report_');
        File::put($tempHtmlFile, $html);

        SnappyPdf::loadHTML($html)->save($pdfPath);

        return [
            Attachment::fromPath($pdfPath)
        ];
    }
}
