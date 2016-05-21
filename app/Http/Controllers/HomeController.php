<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\Article;
use Auth;

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
        $articles = Article::orderBy('published_at', 'desc')->get();
        return view('dashboards.system-administrator-home', compact('articles'));
    }

    /**
     * Redirects to faculty home page with necessary data
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToFacultyHome(){
        $subjects = Auth::user()->subjects()->orderBy('subject_title', 'asc')->get();
        return view('dashboards.faculty-home', compact('subjects'));
    }

    /**
     * Redirects to student home page with necessary data
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToStudentHome(){
        $classes = Auth::user()->classes()->orderBy('subject_title', 'asc')->get();
        return view('dashboards.student-home', compact('classes'));
    }
}
