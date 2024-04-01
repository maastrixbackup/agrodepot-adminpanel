<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalesOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $salesOrderData; // Assuming this variable holds dynamic data related to the sales order

    /**
     * Create a new message instance.
     *
     * @param $salesOrderData Dynamic data related to the sales order
     */
    public function __construct($salesOrderData)
    {
        $this->salesOrderData = $salesOrderData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sales Order',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.salesorderMail',
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
