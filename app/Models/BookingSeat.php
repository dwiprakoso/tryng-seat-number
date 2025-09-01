<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    protected $table = 'booking_seat';

    protected $fillable = [
        'buyer_id',
        'seat_id',
    ];

    /**
     * Relationship with Buyer
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * Relationship with Seat
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
