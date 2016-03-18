<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Auth;
use App\Models\User;

class ArticlesController extends Controller
{
    public function __construct(){
        $this->middleware('role:System Administrator', ['except' => ['show']]);
    }

    public function show(Article $article, Request $request){
        return view('articles.show', compact('article'));
    }

    public function create(){
        return view('articles.create');
    }

    public function store(ArticleRequest $request){
        $article = Auth::user()->articles()->create($request->all());
        flash()->success('Article has been published successfully');
        return redirect('/home');
    }

    public function edit(Article $article){
        return view('articles.edit', compact('article'));
    }

    public function list(){
        $articles = Article::orderBy('published_at', 'desc')->get();
        return view('articles.list', compact('articles'));
    }

    public function update(Article $article, ArticleRequest $request){
        $article->update($request->all());
        flash()->success('Article successfully updated');
        return redirect('articles/list');
    }

    public function destroy(){
        
    }        
}
