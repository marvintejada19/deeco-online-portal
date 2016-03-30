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
	/*
	 * Routes of pages that are viewable by even not logged in, including static pages
	 */
    Route::get('/', 		'WelcomeController@index');
    Route::get('/contact', 	'WelcomeController@contact');
    Route::get('/about',	'WelcomeController@about');

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
     * Routes of pages handling the subjects, subject articles, and subject requirements
     */
    Route::get('subjects/{subject}/posts/{posts}/delete',   'SubjectPostsController@showDeleteConfirmation');
    Route::post('subjects/{subject}/posts/{posts}/delete',   'SubjectPostsController@delete');
    Route::resource('subjects/{subjects}/posts',            'SubjectPostsController', ['except' => 'destroy']);
    Route::resource('subjects/{subjects}/requirements',     'SubjectRequirementsController', ['except' => 'destroy']);
    Route::get('subjects/{subjects}',                       'SubjectsController@show');

    /*
     * Routes of pages covering file management, including uploads and downloads
     */
    Route::get('/up', function(){
        return view('temp');
    });
    Route::post('upload/', 'FilesController@upload');
});

