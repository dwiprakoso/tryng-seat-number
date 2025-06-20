<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'no_handphone',
        'nama_instagram',
        'alamat_lengkap',
        'kode_pos',
        'ukuran_jersey',
        'ticket_id',
        'total_amount',
        'xendit_invoice_id',    // Tambah ini
        'xendit_invoice_url',   // Tambah ini
        'payment_status',       // Tambah ini
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relationship dengan Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
