<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    protected $status;
    protected $productReviewUrl;

    public function __construct($status, $productReviewUrl = null)
    {
        $this->status = $status;
        $this->productReviewUrl = $productReviewUrl;
    }

    public function build()
    {
        return $this->view('mail.order_status_updated')
            ->subject('Your order status has been updated')
            ->with([
                'status' => $this->status,
                'productReviewUrl' => $this->productReviewUrl
            ]);
    }
}


