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
        'avatar'
    ];

    protected $casts = [
        'event_date' => 'date'
    ];
}
