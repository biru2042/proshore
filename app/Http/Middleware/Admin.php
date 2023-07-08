<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (Auth::guest()) {
             return redirect()->guest('admin/login');
        }elseif ( Auth::user()->type == "1" || Auth::user()->type == "2") {
            return $next($request);
        }else{
            return redirect()->guest('admin/login');
        }
       
        
    }
}
