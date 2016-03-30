<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard based on role of user
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $role = $request->user()->getRole();
        
        switch($role){
            case 'System Administrator':
                return $this->redirectToSystemAdminHome();
                break;
            case 'Faculty':
                return $this->redirectToFacultyHome();
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
        $subjects = Auth::user()->subjects;
        return view('dashboards.faculty-home', compact('subjects'));
    }
}
