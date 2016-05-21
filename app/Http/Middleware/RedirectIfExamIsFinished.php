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
        $examination = Route::current()->parameters()['examinations'];
        if (!strcmp($request->user()->getRole(), 'Faculty')){
            $subject = Route::current()->parameters()['subjects'];
            $redirectRoute = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/results';
        } else {
            $subject = Route::current()->parameters()['classes'];
            $redirectRoute = '/classes/' . $subject->id . '/examinations/' . $examination->id . '/results';
        }
        $instance = $examination->instances()->where('user_id', $request->user()->id)->first();
        if ($instance->is_finished){
            return redirect($redirectRoute);
        } else {
            return $next($request);
        }
    }
}
