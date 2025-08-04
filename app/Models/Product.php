<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'location',
        'product_description',
        'event_date',
        'end_date',
        'avatar'
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date' => 'date'  // ✅ Tambahkan ini!
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
