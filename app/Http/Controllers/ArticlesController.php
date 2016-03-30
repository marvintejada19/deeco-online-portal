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
        flash()->success('Article has been saved. It will be published at the specified date.');
        return redirect('/home');
    }

    public function edit(Article $article){
        return view('articles.edit', compact('article'));
    }

    public function update(Article $article, ArticleRequest $request){
        $article->update($request->all());
        flash()->success('Article successfully updated');
        return redirect('/articles/' . $article->id);
    }

    public function showDeleteConfirmation(Article $article){
        return view('articles.delete', compact('article'));
    }

    public function delete(Article $article){
        $article->delete();
        return redirect('/home');
    }        
}
