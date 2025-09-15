<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qty',
        'price',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
