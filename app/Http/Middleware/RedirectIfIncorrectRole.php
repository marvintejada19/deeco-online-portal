<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfIncorrectRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(! empty($request->user())){
            $userRole = $request->user()->getRole();
            if(!strcmp($userRole, $role)){
                return $next($request);
            }
        }
        return redirect('/login');
    }
}
