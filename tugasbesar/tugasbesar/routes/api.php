<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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