<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'status',
        'rumah_makan_id'
    ];

    public function rumahMakan()
    {
        return $this->belongsTo(RumahMakan::class);
    }
}
