<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Exports\HistoriesExport;
use Maatwebsite\Excel\Facades\Excel;
class History extends Mailable
{
    use Queueable, SerializesModels;
    public $history;
    /**
     * Create a new message instance.
     */
    public function __construct()
    {
       // public history  $history;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
          subject: 'History',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.history',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $file= Excel::download(
            new HistoriesExport, 
            'history.xlsx'
        )->getFile();

        return [$file];
    } 
    
}
