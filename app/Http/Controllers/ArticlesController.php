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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('role:System Administrator', ['except' => ['show']]);
    }

    /**
     * Show the contents of the given article
     *
     * @param Article $article
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, Request $request){
        if(empty(Auth::user()) || strcmp(Auth::user()->getRole(), 'System Administrator')){
            if($article->is_unpublished()){
                return redirect('/home');
            }
            $backButtonPath = '/';
        } else {
            $backButtonPath = '/home';
        }
        return view('articles.show', compact('article', 'backButtonPath'));
    }

    /**
     * Show the form in creating articles
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('articles.create');
    }

    /**
     * Store the article in the database
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request){
        $article = Auth::user()->articles()->create($request->all());
        flash()->success('Article has been saved. It will be published at the specified date.');
        return redirect('/home');
    }

    /**
     * Show the form in editing articles 
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article){
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the article in the database
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article, ArticleRequest $request){
        $article->update($request->all());
        flash()->success('Article successfully updated');
        return redirect('/articles/' . $article->id);
    }

    /**
     * Show the form in deleting articles
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function showDeleteConfirmation(Article $article){
        return view('articles.delete', compact('article'));
    }

    /**
     * Delete the article from the database
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function delete(Article $article){
        $article->delete();
        return redirect('/home');
    }        
}
