<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewB2BUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData; // Assuming this variable holds dynamic data related to the sales order

    /**
     * Create a new message instance.
     *
     * @param $salesOrderData Dynamic data related to the sales order
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dezmembraripenet :: Request For B2B User Account Activation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.newB2BUserMail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
