<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    //protected function redirectTo($request)
     public function handle($request,Closure $next)
    { 
        session_start();
        //echo $_SESSION['user_name'];die();


        if (!isset($_SESSION['user_name'])) {
             return redirect('/');
        }else{
            return $next($request);
        }
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
