<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class CheckIfStudentIsEnrolled
{
    /**
     * Handle an incoming request.
     * Disables students from accessing classes they are not enrolled in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty($request->user())){
            $class = Route::current()->parameters()['classes'];
            $student = $class->students()->where('user_id', $request->user()->id)->first();
            if ($student){
                return $next($request);
            }
        }
        return redirect('/home');
    }
}
