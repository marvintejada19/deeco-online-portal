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
	 * Routes of pages that are viewable by even not logged in
	 */
    Route::get('/', 		'WelcomeController@index');
    Route::get('/contact', 	'WelcomeController@contact');
    Route::get('/about',	'WelcomeController@about');

    /*
     * Routes of pages handling the articles
     */
    Route::resource('articles', 'ArticlesController');

    /*
     * Routes of pages covering login authentication and password
     */
    Route::auth();
    Route::get('/home',             'HomeController@index');
    Route::get('/password/change',  'Auth\PasswordController@showPasswordChangeForm');
    Route::post('/password/change',  'Auth\PasswordController@passwordChange');


});

