<?php

namespace App\Mail;

use App\Models\Buyer;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer;
    public $ticket;

    public function __construct(Buyer $buyer, Ticket $ticket)
    {
        $this->buyer = $buyer;
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pesanan Tiket - ' . $this->ticket->name)
            ->view('emails.order-confirmation')
            ->with([
                'buyer' => $this->buyer,
                'ticket' => $this->ticket,
            ]);
    }
}
