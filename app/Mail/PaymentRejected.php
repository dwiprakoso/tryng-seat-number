<?php

namespace App\Mail;

use App\Models\Buyer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Buyer $buyer, $reason)
    {
        $this->buyer = $buyer;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pembayaran Tiket Ditolak - ' . $this->buyer->external_id)
            ->view('emails.payment-rejected');
    }
}
