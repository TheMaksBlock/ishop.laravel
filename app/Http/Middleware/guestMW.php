<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class guestMW
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect()->route("main.index");
        }

        return $next($request);
    }
}
