<?php

namespace App\Mail;

use App\Models\ReservaSalon;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ReservaSalonActualizarMail extends Mailable
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
            subject: __('mail.actualizar1'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.reservaSalons.mailActualizar',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $reservaSalon = ReservaSalon::find($this->data['reservaId']);

        $html = view('admin.reservaSalons.facturaPdf', ['reservaSalon' => $reservaSalon])->render();

        $tempHtmlFile = tempnam(sys_get_temp_dir(), 'report_');
        File::put($tempHtmlFile, $html);

        $pdfPath = storage_path('app/reservaSalons/factura' . $reservaSalon->id . '.pdf');

        SnappyPdf::loadHTML($html)->save($pdfPath);

        return [
            Attachment::fromPath($pdfPath)
        ];
    }
}
