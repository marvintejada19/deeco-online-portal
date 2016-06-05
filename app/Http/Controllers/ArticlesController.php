<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Subjects\Section;
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
        $this->middleware('role:System Administrator');
    }

    /**
     * Show the menu concerning articles
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('articles.index');
    }

    /**
     * Show the contents of the given article
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article){
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form in creating articles
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $sectionList = Section::get();
        $sections = [];
        foreach($sectionList as $section){
            $sections[$section->id] = $section->getName();
        }
        $subjects = [];
        foreach($sectionList as $section){
            $subject_arr = [];
            foreach($section->subjects as $subject){
                $subject_arr[] = $subject;
            }
            $subjects[$section->id] = $subject_arr;
        }
        return view('articles.create', compact('sections', 'subjects'));
    }

    /**
     * Store the article in the database
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request){
        Article::create($request->all());
        flash()->success('Article has been saved. It will be published at the specified date.');
        return redirect('/articles');
    }

    public function list(){
        $articles = Article::get();
        return view('articles.list', compact('articles'));
    }

    /**
     * Show the form in editing articles 
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    // public function edit(Article $article){
    //     return view('articles.edit', compact('article'));
    // }

    /**
     * Update the article in the database
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    // public function update(Article $article, ArticleRequest $request){
    //     $article->update($request->all());
    //     flash()->success('Article successfully updated');
    //     return redirect('/articles/' . $article->id);
    // }

    // /**
    //  * Show the form in deleting articles
    //  *
    //  * @param Article $article
    //  * @return \Illuminate\Http\Response
    //  */
    // public function showDeleteConfirmation(Article $article){
    //     return view('articles.delete', compact('article'));
    // }

    // /**
    //  * Delete the article from the database
    //  *
    //  * @param Article $article
    //  * @return \Illuminate\Http\Response
    //  */
    // public function delete(Article $article){
    //     $article->delete();
    //     return redirect('/home');
    // }        
}
