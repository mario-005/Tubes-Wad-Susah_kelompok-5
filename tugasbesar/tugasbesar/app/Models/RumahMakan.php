<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahMakan extends Model
{
    use HasFactory;

    // Allow mass-assignment only for these fields
    protected $fillable = [
        'nama', 
        'alamat', 
        'kontak', 
        'kategori',
        'jam_buka',
        'jam_tutup',
        'foto'
    ];

    // Relationship with menus
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Relationship with rooms
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Relationship with reservations
    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Room::class);
    }

    // Relationship with operational statuses
    public function operationalStatuses()
    {
        return $this->hasMany(OperationalStatus::class);
    }

    // Relationship with reviews
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'nama_rumah_makan', 'nama');
    }
}
