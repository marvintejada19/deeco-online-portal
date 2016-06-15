<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class RedirectIfExamIsFinished
{
    /**
     * Handle an incoming request.
     * Prevents students from going back to exam questions after submitting their answers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $deployment = Route::current()->parameters()['deployments'];        
        $gradeSectionSubject = Route::current()->parameters()['classes'];
        $redirectRoute = '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/results';
        $instance = $deployment->instances()->where('user_id', $request->user()->id)->first();
        if ($instance->is_finished){
            return redirect($redirectRoute);
        } else {
            return $next($request);
        }
    }
}
