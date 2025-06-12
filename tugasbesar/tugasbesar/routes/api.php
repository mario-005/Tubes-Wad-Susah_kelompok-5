<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
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
=======
use App\Models\RumahMakan;
use App\Http\Controllers\RumahMakanController;

// Get all rumah makan with relationships
Route::get('/rumah-makan', function () {
    try {
        $rumahMakans = RumahMakan::all();
        return response()->json([
            'status' => 'success',
            'data' => $rumahMakans
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage()
        ], 500);
    }
});

// Get single rumah makan by ID
Route::get('/rumah-makan/{id}', function ($id) {
    try {
        $rumahMakan = RumahMakan::with(['menus', 'rooms', 'ulasans'])->find($id);
        
        if (!$rumahMakan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rumah makan not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $rumahMakan
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage()
        ], 500);
    }
});

// Fallback route for undefined API endpoints
Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'API endpoint not found'
    ], 404);
}); 
>>>>>>> 0d42d785b1c2c7dc54edb5b62dad592cec9086ab
