<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Http\Requests\UserRequest;
use DB;
use Random;

class UsersController extends Controller
{
    public function index(){
    	$users = User::get();
    	return view('users.index', compact('users'));
    }

    public function indexOfSchoolManagement(){
    	$users = User::where('role_id', '2')->orderBy('id', 'desc')->get();
    	return view('users.school-management', compact('users'));
    }

    public function indexOfFaculty(){
    	$users = User::where('role_id', '3')->orderBy('id', 'desc')->get();
    	return view('users.faculty', compact('users'));
    }

    public function indexOfStudents(){
    	$users = User::where('role_id', '4')->orderBy('id', 'desc')->get();
    	return view('users.students', compact('users'));
    }

    public function create(){
    	$roles = DB::table('roles')->where('id', '<>', 1)->lists('title', 'id');
    	$randKey = Random::generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    	return view('auth.register', compact('users', 'roles', 'randKey'));
    }

    public function store(UserRequest $request){
    	User::create([
            'username'  => $request->input('username'),
            'password'  => bcrypt($request->input('password')),
            'role_id'   => $request->input('role_id')
        ]);
    	switch($request->input('role_id')){
    		case '2':
	    		return redirect('/users/school-management');
    			break;
    		case '3':
    			return redirect('/users/faculty');
    			break;
    		case '4':
    			return redirect('/users/students');
    			break;
    	}
    }
}
