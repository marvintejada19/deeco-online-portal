<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function __construct(){
    }

    public function show(Article $article){
        return view('articles.show', compact('article'));
    }

    public function create(){
        return view('articles.create');
    }

    public function store(ArticleRequest $request){
        $this->createArticle($request);
    }

    public function edit(ArticleRequest $request){
        return view('articles.edit', compact('article'));
    }

    public function destroy(){
        
    }
}
