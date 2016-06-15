<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class CheckExaminationQuestions
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
        $examination = Route::current()->parameters()['examinations'];
        if (count($examination->parts) == 0){
            flash()->error('Please specify the parts first.');
            return redirect('examinations/'. $examination->id . '/parts');
        }
        foreach ($examination->parts as $part){
            if ($part->getQuestionsCount() != $part->questions_quantity){
                flash()->error('A part of the exam has unequal current number of questions and total number of questions.');
                return redirect('examinations/'. $examination->id . '/parts');
            }
        }
        return $next($request);
    }
}
