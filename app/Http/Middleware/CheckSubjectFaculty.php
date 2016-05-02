<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class CheckSubjectFaculty
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
        if(! empty($request->user())){
            $subjectFaculty = Route::current()->parameters()['subjects']->faculty->username;
            $user = $request->user()->username;
            if(!strcmp($subjectFaculty, $user)){
                return $next($request);
            }
        }
        return redirect('/home');
    }
}
