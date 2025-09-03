<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'mewakili',                    // field dari tabel
        'email',
        'no_handphone',
        'alamat_lengkap',
        'identitas_number',            // field dari tabel
        'quantity',
        'ticket_id',
        'ticket_price',
        'admin_fee',
        'total_amount',
        'payment_status',
        'payment_code',                // ← DITAMBAHKAN (field yang hilang)
        'payment_proof',               // ← DITAMBAHKAN (field yang hilang)
        'external_id',
        'payment_confirmed_at',        // field dari tabel (timestamp)

        // Field datetime Laravel standar
        'created_at',
        'updated_at',

        // Field lain yang mungkin digunakan (jika ada)
        'qr_code_path',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'paid_at',
        'payment_updated_at',
        'payment_method',
        'rejection_reason',
        'payment_channel'
    ];

    protected $casts = [
        'payment_confirmed_at' => 'datetime',   // field dari tabel
        'paid_at' => 'datetime',
        'payment_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'ticket_price' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relasi ke tabel tickets
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Accessor untuk format currency Indonesia
    public function getFormattedTicketPriceAttribute()
    {
        return 'Rp ' . number_format($this->ticket_price, 0, ',', '.');
    }

    public function getFormattedAdminFeeAttribute()
    {
        return 'Rp ' . number_format($this->admin_fee, 0, ',', '.');
    }

    public function getFormattedTotalAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    // Scope untuk filter berdasarkan status pembayaran
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeWaitingConfirmation($query)
    {
        return $query->where('payment_status', 'waiting_confirmation');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('payment_status', 'confirmed');
    }

    // Method untuk mengecek status pembayaran
    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isWaitingConfirmation()
    {
        return $this->payment_status === 'waiting_confirmation';
    }

    public function isConfirmed()
    {
        return $this->payment_status === 'confirmed';
    }

    // Method untuk update payment proof
    public function updatePaymentProof($proofUrl, $paymentCode = null)
    {
        return $this->update([
            'payment_proof' => $proofUrl,
            'payment_code' => $paymentCode,
            'payment_status' => 'waiting_confirmation'
        ]);
    }

    // Method untuk konfirmasi pembayaran
    public function confirmPayment()
    {
        return $this->update([
            'payment_status' => 'confirmed',
            'payment_confirmed_at' => now()
        ]);
    }
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seat', 'buyer_id', 'seat_id');
    }
    public function getQrCodeDataUrl()
    {
        if (!$this->qr_code) {
            return null;
        }

        return 'data:image/png;base64,' . $this->qr_code;
    }
}
