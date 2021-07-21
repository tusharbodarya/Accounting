<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check() && ($request->path() !='login') && ($request->path() !='register')){
             return redirect('login')->with('fail','You Must be logged in');
        }
        if(Auth::check() && ($request->path() =='login') || ($request->path() =='register')){
            return back();
       }
        return $next($request)->header('Cache-Control','no-cache , no-store , max-age-0 , must-revalidate')
                              ->header('pragma','no-cache')
                              ->header('Expires','sat 01 jan 1990 00:00:00 GMT');
    }
}
