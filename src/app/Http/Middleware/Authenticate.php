<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next, ...$guards) {


        // If authenticated, proceed with the request
        return $next($request);
    }

}
