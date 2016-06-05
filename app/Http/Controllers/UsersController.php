<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserDetailRequest;
use App\Models\User;
use App\Models\GradeSections\GradeSection;
use DB;
use Random;
use Auth;

class UsersController extends Controller
{
    public function index(){
    	$users = User::get();
    	return view('users.index', compact('users'));
    }

    public function indexOfSchoolManagement(){
    	$users = User::where('role_id', '2')->orderBy('username', 'asc')->get();
    	return view('users.school-management', compact('users'));
    }

    public function indexOfFaculty(){
    	$users = User::where('role_id', '3')->orderBy('username', 'asc')->get();
    	return view('users.faculty', compact('users'));
    }

    public function indexOfStudents(){
        $activeSchoolYear = DB::table('school_years')->where('active', '1')->first();
    	$users = User::where('role_id', '4')->orderBy('username', 'asc')->get();
    	return view('users.students', compact('users', 'activeSchoolYear'));
    }

    public function create(){
    	$roles = DB::table('roles')->lists('title', 'id');
    	$randKey = Random::generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    	return view('auth.register', compact('users', 'roles', 'randKey'));
    }

    public function store(UserRequest $request){
    	$user = User::create([
                    'username'  => $request->input('username'),
                    'password'  => bcrypt($request->input('password')),
                    'role_id'   => $request->input('role_id')
                ]);
    	switch($request->input('role_id')){
            case '1':
                $this->deactivate(Auth::user());
                return redirect('/logout');
                break;
    		case '2':
                DB::table('school_management')->insert([
                    'user_id' => $user->id,
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'idNumber' => $request->input('idNumberPre') . '-' . $request->input('idNumberPost'),
                    'gender' => $request->input('gender'),
                ]);
	    		return redirect('/users/school-management');
    			break;
    		case '3':
                DB::table('faculty')->insert([
                    'user_id' => $user->id,
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'idNumber' => $request->input('idNumberPre') . '-' . $request->input('idNumberPost'),
                    'gender' => $request->input('gender'),
                ]);
                return redirect('/users/faculty');
    			break;
    		case '4':
                DB::table('students')->insert([
                    'user_id' => $user->id,
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'idNumber' => $request->input('idNumberPre') . '-' . $request->input('idNumberPost'),
                    'lrnNumber' => $request->input('lrnNumber'),
                    'gender' => $request->input('gender'),
                ]);
    			return redirect('/users/students');
    			break;
    	}
    }

    public function edit(User $user){
        $idNumberParts = explode('-', $user->getInfo()->idNumber);
        return view('users.edit', compact('user', 'idNumberParts'));
    }

    public function update(User $user, UserDetailRequest $request){
        switch($user->role_id){
            case '2':
                DB::table('school_management')->where('user_id', $user->id)->update([
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'idNumber' => $request->input('idNumberPre') . '-' . $request->input('idNumberPost')
                ]);
                return redirect('/users/school-management');
                break;
            case '3':
                DB::table('faculty')->where('user_id', $user->id)->update([
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'idNumber' => $request->input('idNumberPre') . '-' . $request->input('idNumberPost')
                ]);
                return redirect('/users/faculty');
                break;
            case '4':
                DB::table('students')->where('user_id', $user->id)->update([
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'idNumber' => $request->input('idNumberPre') . '-' . $request->input('idNumberPost'),
                    'lrnNumber' => $request->input('lrnNumber'),
                ]);
                return redirect('/users/students');
                break;
        } 
    }

    public function activateUser(User $user){
        $user->active = 1;
        $user->update();
        switch ($user->role_id){
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

    public function deactivateUser(User $user){
        $this->deactivate($user);
        switch ($user->role_id){
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

    public function enrollment($gradeSectionSelected = null, $studentsEnrolledInGradeSection = null){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
        $studentsList = User::where('role_id', '4')->orderBy('username', 'asc')->where('active', '1')->get();
        $students = [];
        foreach ($studentsList as $student){
            $gradeSection = $student->gradeSections->where('school_year_id', $activeSchoolYear->id)->first();
            if ($gradeSection == null){
                $students[] = $student;
            }
        }
        $gradeSections = GradeSection::get();
        return view('users.enrollment', compact('students', 'gradeSections', 'gradeSectionSelected', 'studentsEnrolledInGradeSection'));
    }

    public function postSearch(Request $request){
        $gradeSection = GradeSection::find($request->input('gradeSectionId'));
        $students = $gradeSection->students;
        return $this->enrollment($gradeSection, $students);
    }

    public function enroll(Request $request){
        $gradeSection = GradeSection::find($request->input('enrollSection'));
        $selectedIds = explode(',', $request->input('enrollList'));
        $gradeSection->students()->sync($selectedIds);
        return redirect('/grade-sections/' . $gradeSection->id);
    }

    private function deactivate(User $user){
        $user->active = 0;
        $user->update();
    }

}
