<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Subject;

class SubjectsController extends Controller
{
    public function show(Subject $subject){
    	$students = $subject->students();
    	return view('subjects.show', compact('subject', 'students'));
    }
}
