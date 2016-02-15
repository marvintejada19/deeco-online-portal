<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * Show the contact page
     *
     * @return \Illuminate\Http\Response
     */
    public function contact(){
    	return view('main/contact');
    }

    /**
     * Show the about page
     *
     * @return \Illuminate\Http\Response
     */
    public function about(){
    	return view('main/about');
    }

    /**
	 * Show the main page, the starting point of the site
	 *
	 * @return \Illuminate\Http\Response
     */
    public function index(){
    	return view('main/welcome');
    }
}
