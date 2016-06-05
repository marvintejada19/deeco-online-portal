<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard based on role of user
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request){
        $role = $request->user()->getRole();
        switch($role){
            case 'System Administrator':
                return $this->redirectToSystemAdminHome();
                break;
            case 'School Management':
                return $this->redirectToSchoolManagementHome();    
            case 'Faculty':
                return $this->redirectToFacultyHome();
                break;
            case 'Student':
                return $this->redirectToStudentHome();
                break;
            default:
                return redirect('/');
        }
    }

    /**
     * Redirects to system administrator home page with necessary data
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToSystemAdminHome(){
        $activeSchoolYear = DB::table('school_years')->where('active', '1')->first();
        return view('dashboards.system-administrator-home', compact('activeSchoolYear'));
    }

    /**
     * Redirects to system administrator home page with necessary data
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToSchoolManagementHome(){
        return view('dashboards.system-administrator-home');
    }

    /**
     * Redirects to faculty home page with necessary data
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToFacultyHome(){
        // $facultyLoadings = Auth::user()->facultyLoadings->pluck('id');
        // $gradeSectionSubjects = GradeSectionSubject::whereIn('faculty_loading_id', $facultyLoadings)->get();
        $gradeSectionSubjects = Auth::user()->gradeSectionSubjects;
        return view('dashboards.faculty-home', compact('gradeSectionSubjects'));
    }

    /**
     * Redirects to student home page with necessary data
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToStudentHome(){
        $activeSchoolYear = DB::table('school_years')->where('active', '1')->first();
        $gradeSection = Auth::user()->gradeSections->where('school_year_id', $activeSchoolYear->id)->first();
        $gradeSectionSubjects = GradeSectionSubject::where('grade_section_id', $gradeSection->id)->get();;
        return view('dashboards.student-home', compact('gradeSectionSubjects'));
    }
}
