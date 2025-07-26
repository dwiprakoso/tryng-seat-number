<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerCheckin extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'qty',
        'checked_in_at'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
