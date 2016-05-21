<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Flash;

class RedirectIfExamIsPublished
{
    /**
     * Handle an incoming request.
     * Prevents a faculty from modifying an exam that is published.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subject = Route::current()->parameters()['subjects'];
        $examination = Route::current()->parameters()['examinations'];
        if ($examination->is_published){
            //Flash::error('You cannot perform that action while the examination is published. Unpublish the examination first.');
            Flash::error('You cannot perform that action while the examination is published.');
            return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id);
        } else {
            return $next($request);
        }
    }
}
