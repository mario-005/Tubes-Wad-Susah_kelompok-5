<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'open_time',
        'close_time',
        'status',
        'rumah_makan_id'
    ];

    protected $casts = [
        'date' => 'date',
        'open_time' => 'datetime',
        'close_time' => 'datetime'
    ];

    public function rumahMakan()
    {
        return $this->belongsTo(RumahMakan::class);
    }
}
