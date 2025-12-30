<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\RumahMakan;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $menus = Menu::all();
            $rumahMakans = RumahMakan::all();
            
            // Admin dan user sama-sama ke dashboard, tapi tampilan berbeda di view
            return view('dashboard', compact('menus', 'rumahMakans')); 
        } catch (\Exception $e) {
            \Log::error('DashboardController@index error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }
}
