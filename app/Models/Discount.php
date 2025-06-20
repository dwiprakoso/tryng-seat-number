<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qty',
        'price',
        'status',
        'ticket_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
