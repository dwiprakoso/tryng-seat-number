<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtsSales extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'no_handphone',
        'ticket_id',
        'quantity',
        'ticket_price',
        'admin_fee',
        'total_amount',
        'payment_method',
    ];

    protected $casts = [
        'ticket_price' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
