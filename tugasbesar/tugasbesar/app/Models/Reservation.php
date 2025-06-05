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
        'reservation_date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
