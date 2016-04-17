<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class QuestionsController extends Controller
{
	public function __construct(){
    }

    public function create(){
    	return view('questions.create');	
    }
}
