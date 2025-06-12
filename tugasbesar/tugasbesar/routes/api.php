<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\RumahMakan;

Route::get('/rumah-makan', function () {
    return RumahMakan::with(['menus', 'rooms', 'ulasans'])->get();
}); 