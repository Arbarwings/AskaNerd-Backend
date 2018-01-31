<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsNerd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard() &&  Auth::guard()->user()->type == 2) {
            return $next($request);
        }

        return response()->json([
            'error' => [
                'message' => 'You are not a Nerd',
                'status_code' => 401
            ]
        ], 401);
    }
}
