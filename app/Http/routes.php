<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () {
	
    Route::get('/', 		'WelcomeController@index');

    /*
     * Routes of pages covering login authentication and password
     */
    Route::auth();
    Route::get('/home', 'HomeController@index');

    /*
     * Routes of pages handling the articles posted by the System Administrator
     */
    Route::get('/articles/list',    'ArticlesController@list');
    Route::get('/articles/{articles}/delete',  'ArticlesController@showDeleteConfirmation');
    Route::post('/articles/{articles}/delete',  'ArticlesController@delete');
    Route::resource('articles',     'ArticlesController', ['except' => 'index', 'destroy']);

    /*
     * Routes of pages handling the subjects, subject articles, subject requirements, and examinations
     */
    Route::get('subjects/{subject}/posts/{posts}/delete',   'Subjects\SubjectPostsController@showDeleteConfirmation');
    Route::post('subjects/{subject}/posts/{posts}/delete',  'Subjects\SubjectPostsController@delete');
    Route::resource('subjects/{subjects}/posts',            'Subjects\SubjectPostsController', ['except' => 'destroy']);
    
    Route::get('subjects/{subject}/requirements/{requirements}/delete',   'Subjects\SubjectRequirementsController@showDeleteConfirmation');
    Route::post('subjects/{subject}/requirements/{requirements}/delete',  'Subjects\SubjectRequirementsController@delete');
    Route::resource('subjects/{subjects}/requirements',     'Subjects\SubjectRequirementsController', ['except' => 'destroy']);
    
    Route::get('subjects/{subject}/examinations/{examinations}/delete',   'Subjects\SubjectExaminationsController@showDeleteConfirmation');
    Route::post('subjects/{subject}/examinations/{examinations}/delete',  'Subjects\SubjectExaminationsController@delete');
    Route::resource('subjects/{subjects}/examinations',     'Subjects\SubjectExaminationsController', ['except' => 'destroy']);
    
    Route::get('subjects/{subjects}/details',               'Subjects\SubjectsController@showDetails');
    Route::get('subjects/{subjects}',                       'Subjects\SubjectsController@show');

    /*
     * Routes of pages handling the question bank
     */
    Route::resource('questions/categories/{categories}/topics/{topics}/subtopics', 'Questions\QuestionSubtopicsController');
    Route::resource('questions/categories/{categories}/topics', 'Questions\QuestionTopicsController');
    Route::resource('questions/categories', 'Questions\QuestionCategoriesController');
    Route::resource('questions',     'Questions\QuestionsController', ['except' => 'destroy']);

    
    /*
     * Routes of pages covering file downloads
     */
    Route::post('download', 'FilesController@download');
    Route::get('files/{files}', 'FilesController@viewDownloadHistory');
});

