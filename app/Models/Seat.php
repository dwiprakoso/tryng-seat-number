<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',        // Add this field
        'seat_number',
        'is_booked'
    ];

    protected $casts = [
        'is_booked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope untuk kursi yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('is_booked', false);
    }

    // Scope untuk kursi yang sudah dipesan
    public function scopeBooked($query)
    {
        return $query->where('is_booked', true);
    }

    // Accessor untuk status kursi
    public function getStatusAttribute()
    {
        return $this->is_booked ? 'Terpesan' : 'Tersedia';
    }

    // Accessor untuk status color
    public function getStatusColorAttribute()
    {
        return $this->is_booked ? 'danger' : 'success';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
