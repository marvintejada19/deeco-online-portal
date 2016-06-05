<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use DB;
use Auth;

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
            $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
            $class = Route::current()->parameters()['classes'];
            $student = DB::table('enrollments')->where('user_id', Auth::user()->id)->where('grade_section_id', $class->gradeSection->id)->first();
            if ($student){
                return $next($request);
            }
        }
        return redirect('/home');
    }
}
