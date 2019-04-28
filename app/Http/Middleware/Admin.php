<?php

namespace App\Http\Middleware;

use App\User;
use Illuminate\Support\Facades\Gate;
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
        $user = auth()->user();
        if ($user->roles->contains('title', 'admin')) {
            return $next($request);
        }

        return redirect('/');
    }
}
