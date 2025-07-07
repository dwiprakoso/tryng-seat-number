<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_handphone',
        'nama_instagram',
        'alamat_lengkap',
        'kode_pos',
        'ukuran_jersey',
        'quantity',
        'ticket_id',
        'ticket_price',
        'admin_fee',
        'total_amount',
        'external_id',
        'qr_code',
        'qr_code_path',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'payment_status',
        'paid_at',
        'payment_updated_at',
        'payment_method',
        'payment_channel'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'payment_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
