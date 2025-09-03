<?php

namespace App\Mail;

use App\Models\Buyer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Buyer $buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Load relasi yang dibutuhkan untuk email template
        $this->buyer->load(['ticket', 'bookingSeats.seat']);

        return $this->subject('Pembayaran Tiket Dikonfirmasi - ' . $this->buyer->external_id)
            ->view('emails.payment-confirmed')
            ->with([
                'buyer' => $this->buyer,
            ]);
    }
}
