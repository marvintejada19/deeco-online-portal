<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticlesController;
use App\Models\Article;

class WelcomeController extends Controller
{
    /**
	 * Show the main page, the starting point of the site. Also retrieve articles 
     * to be shown in main page
     *
	 * @return \Illuminate\Http\Response
     */
    public function index(){
        $articles = Article::orderBy('published_at', 'desc')->published()->get();
        return view('welcome', compact('articles'));
    }
}
