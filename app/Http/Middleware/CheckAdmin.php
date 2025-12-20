<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();
        if (!$user || strtolower(trim($user->role)) !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access. You must be an admin to access this page.');
        }

        return $next($request);
    }
}
