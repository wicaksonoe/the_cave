<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

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

        try {
            $cookie_array = explode('; ', $request->header('cookie'));
            
            foreach ($cookie_array as $value) {
                $data = explode('=', $value);
                $cookie[$data[0]] = $data[1];
            }
        } catch (\Exception $th) {
            return redirect()->back();
        }

        if (isset($cookie['access_token'])) {
            $request->headers->set('Authorization', 'Bearer '.$cookie['access_token']);
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
