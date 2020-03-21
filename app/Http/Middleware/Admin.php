<?php

namespace App\Http\Middleware;

use App\Helpers;
use Closure;

class Admin
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
        if (Helpers::isAdmin()) {
            return $next($request);
        }

        return redirect('/');
    }
}
