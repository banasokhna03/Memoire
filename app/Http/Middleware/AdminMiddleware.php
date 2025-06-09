<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role;
            
            if ($role && $role->name === 'admin') {
                return $next($request);
            }
        }

        abort(403, 'Accès refusé');
    }
}