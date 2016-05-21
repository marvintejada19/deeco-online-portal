<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Subjects\Section;

class SectionsController extends Controller
{
	public function index(){
		$sections = Section::orderBy('grade_level', 'asc')->get();
		return view('subjects.sections.index', compact('sections'));
	}

    public function create(){
    	return view('subjects.sections.create');
    }

    public function store(Request $request){
    	Section::create([
            'grade_level'  => $request->input('grade_level'),
            'section_name' => $request->input('section_name'),
        ]);
    	return redirect('/subject-sections/sections');
    }
}
