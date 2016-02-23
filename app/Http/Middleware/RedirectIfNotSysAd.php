<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotSysAd
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
        if($request->user()->role() != 'System Admin'){
            return redirect('/home');
        }
        else{
            return $next($request);
        }
    }
}
