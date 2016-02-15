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
	 * Concerns pages that are viewable by even not logged in
	 */
    Route::get('/', 		'PublicController@index');
    Route::get('/contact', 	'PublicController@contact');
    Route::get('/about',	'PublicController@about');

    /*
     * Concerns pages covering login authentication
     */
    Route::auth();
    Route::get('/home', 'HomeController@index');


});

