<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle($request, Closure $next)
    {
    	
        if (!Auth::check()) {
            return redirect()->route('login');
        } elseif (Auth::user()->role != 1) {
            return abort(404);
        }

        return $next($request);
    }
}
