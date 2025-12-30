<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get safe image URL with fallback
     */
    public static function getImageUrl($path, $default = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4')
    {
        if (empty($path)) {
            return $default;
        }

        try {
            $disk = config('filesystems.default');
            return Storage::disk($disk)->url($path);
        } catch (\Exception $e) {
            \Log::warning('ImageHelper: Failed to get URL for path: ' . $path);
            return $default;
        }
    }

    /**
     * Get restaurant image URL
     */
    public static function getRestaurantImage($restaurant)
    {
        if (!$restaurant || empty($restaurant->foto)) {
            return 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4';
        }
        return static::getImageUrl($restaurant->foto);
    }

    /**
     * Get menu image URL
     */
    public static function getMenuImage($menu)
    {
        if (!$menu || empty($menu->image)) {
            return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c';
        }
        return static::getImageUrl($menu->image, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c');
    }
}
