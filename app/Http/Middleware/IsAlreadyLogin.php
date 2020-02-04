<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAlreadyLogin
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
        $current_url = url()->current();
        if ($current_url == url('login') || $current_url == url('register')) {
            return $next($request);
        }

        if (Auth::guard()->user() == NULL) {
            return redirect('login');
        }

        return $next($request);
    }
}
