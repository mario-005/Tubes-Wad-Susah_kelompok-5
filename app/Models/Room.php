<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $fillable = [
        'name',
        'capacity',
        'status',
        'rumah_makan_id'
    ];

    public function rumahMakan()
    {
        return $this->belongsTo(RumahMakan::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
