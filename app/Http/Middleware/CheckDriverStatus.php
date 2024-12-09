<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDriverStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $driver_status
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $driver_status)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user()->driver;

        if ($user->status == $driver_status) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
