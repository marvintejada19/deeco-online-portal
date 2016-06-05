<?php

namespace App\Http\Controllers\AdminFunctionalities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\GradeSections\Subject;

class SubjectsController extends Controller
{
	public function index(){
		$subjects = Subject::orderBy('name', 'asc')->get();
		return view('grade-sections.subjects.index', compact('subjects'));
	}
 
    public function create(){
    	return view('grade-sections.subjects.create');
    }

    public function store(Request $request){
    	Subject::create([
    		'name' => $request->input('name'),
    	]);
    	return redirect('/others/subjects');
    }
}
