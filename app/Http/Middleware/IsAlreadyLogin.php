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
        dd($request);
        $cookie_array = explode('; ', $request->header('cookie'));

        foreach ($cookie_array as $value) {
            $data = explode('=', $value);
            $cookie[$data[0]] = $data[1];
        }

        dd(Auth::guard());

        // Check if access_token available
        // if (isset($cookie['access_token'])) {
        //     # code...
        // }
        // true = validate access_token

        // check if access_token valid

        // true = redirect to dahsboard


        // redirect to login


        // $current_url = url()->current();
        // if ($current_url == url('login') || $current_url == url('register')) {
        //     return $next($request);
        // }

        // if (Auth::guard()->user() == NULL) {
        //     return redirect('login');
        // }

        // return $next($request);
    }
}
