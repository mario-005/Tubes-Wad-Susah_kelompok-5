<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'guest_name',
        'reservation_date',
        'start_time',
        'end_time',
        'purpose',
        'status'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function rumahMakan()
    {
        return $this->hasOneThrough(RumahMakan::class, Room::class);
    }
}
