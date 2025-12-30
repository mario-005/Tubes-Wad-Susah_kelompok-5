<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    // Helper method to get image URL
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c';
        }
        
        try {
            $disk = config('filesystems.default');
            return Storage::disk($disk)->url($this->image);
        } catch (\Exception $e) {
            return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c';
        }
    }
}
