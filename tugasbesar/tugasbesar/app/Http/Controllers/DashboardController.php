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
        if (Auth::check() && Auth::user()->role !== 'user') {
            return redirect()->route('menus.index'); 
        } else {
            $menus = Menu::all();
            $rumahMakans = RumahMakan::all();
            return view('dashboard', compact('menus', 'rumahMakans')); 
        }
    }
}
