<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = $request->user()->getRole();
        
        switch($role){
            case 'System Administrator':
                return view('dashboards.system-administrator-home');
                break;
            case 'Faculty':
                return view('dashboards.faculty-home');
                break;
            default:
                return redirect('/');
        }
    }

    
}
