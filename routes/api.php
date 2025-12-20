<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RumahMakanApiController;
use App\Http\Controllers\Api\MenuApiController;

Route::get('rumah-makan', [RumahMakanApiController::class, 'index']);
Route::get('rumah-makan/{id}', [RumahMakanApiController::class, 'show']);
Route::get('menu', [MenuApiController::class, 'index']);
Route::get('menu/{id}', [MenuApiController::class, 'show']);
Route::get('room', [App\Http\Controllers\Api\RoomApiController::class, 'index']);
Route::get('room/{id}', [App\Http\Controllers\Api\RoomApiController::class, 'show']);
Route::get('reservation', [App\Http\Controllers\Api\ReservationApiController::class, 'index']);
Route::get('reservation/{id}', [App\Http\Controllers\Api\ReservationApiController::class, 'show']);
Route::get('operational-status', [App\Http\Controllers\Api\OperationalStatusApiController::class, 'index']);
Route::get('operational-status/{id}', [App\Http\Controllers\Api\OperationalStatusApiController::class, 'show']); 
