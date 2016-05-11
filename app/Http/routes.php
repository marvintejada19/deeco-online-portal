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
	Route::get('/foo', 'WelcomeController@foo');
    Route::get('/', 'WelcomeController@index');

    /*
     * Routes of pages covering login authentication and password
     */
    Route::auth();
    Route::get('/home', 'HomeController@index');

    /*
     * Routes of pages handling the articles posted by the System Administrator
     */
    Route::get('/articles/{articles}/delete', 'ArticlesController@showDeleteConfirmation');
    Route::post('/articles/{articles}/delete', 'ArticlesController@delete');
    Route::resource('articles', 'ArticlesController', ['except' => ['index', 'destroy']]);

    /*
     * Routes of pages handling the subjects, subject articles, subject requirements, and examinations
     */
    Route::group(['middleware' => ['role:Faculty', 'subjectFaculty']], function () {
        Route::get('subjects/{subjects}/posts/{posts}/delete', 'Subjects\SubjectPostsController@showDeleteConfirmation');
        Route::post('subjects/{subjects}/posts/{posts}/delete', 'Subjects\SubjectPostsController@delete');
        Route::resource('subjects/{subjects}/posts', 'Subjects\SubjectPostsController', ['except' => ['destroy']]);
        
        Route::get('subjects/{subjects}/requirements/{requirements}/delete',   'Subjects\SubjectRequirementsController@showDeleteConfirmation');
        Route::post('subjects/{subjects}/requirements/{requirements}/delete',  'Subjects\SubjectRequirementsController@delete');
        Route::resource('subjects/{subjects}/requirements',     'Subjects\SubjectRequirementsController', ['except' => ['destroy']]);

        Route::post('subjects/{subjects}/examinations/{examinations}/questions/add/{questions}', 'Subjects\SubjectExaminationQuestionsController@add');
        Route::get('subjects/{subjects}/examinations/{examinations}/questions/remove/{questions}', 'Subjects\SubjectExaminationQuestionsController@remove');
        Route::get('subjects/{subjects}/examinations/{examinations}/questions/list', 'Subjects\SubjectExaminationQuestionsController@list');
        Route::get('subjects/{subjects}/examinations/{examinations}/questions/{questions}/instance', 'Subjects\SubjectExaminationQuestionsController@generateInstance');        
        Route::post('subjects/{subjects}/examinations/{examinations}/questions/{questions}/instance/results', 'Subjects\SubjectExaminationQuestionsController@processInstance');        
        Route::get('subjects/{subjects}/examinations/{examinations}/questions/{questions}', 'Subjects\SubjectExaminationQuestionsController@show');        
        Route::get('subjects/{subjects}/examinations/{examinations}/questions/', 'Subjects\SubjectExaminationQuestionsController@search');
        Route::post('subjects/{subjects}/examinations/{examinations}/questions/', 'Subjects\SubjectExaminationQuestionsController@postSearch');

        Route::get('subjects/{subjects}/examinations/{examinations}/delete',   'Subjects\SubjectExaminationsController@showDeleteConfirmation');
        Route::post('subjects/{subjects}/examinations/{examinations}/delete',  'Subjects\SubjectExaminationsController@delete');
        Route::get('subjects/{subjects}/examinations/{examinations}/instances', 'Subjects\SubjectExaminationsController@showInstanceConfirmation');
        Route::post('subjects/{subjects}/examinations/{examinations}/instances', 'Subjects\SubjectExaminationsController@createExaminationInstance');
        Route::get('subjects/{subjects}/examinations/{examinations}/instances/{instances}/page/finish', 'Subjects\SubjectExaminationsController@showExamFinishPage');
        Route::post('subjects/{subjects}/examinations/{examinations}/instances/{instances}/page/finish', 'Subjects\SubjectExaminationsController@finish');
        Route::get('subjects/{subjects}/examinations/{examinations}/instances/{instances}/page/{page}', 'Subjects\SubjectExaminationsController@showExamPage');
        Route::post('subjects/{subjects}/examinations/{examinations}/instances/{instances}/page/{page}', 'Subjects\SubjectExaminationsController@processExamPage');
        Route::get('subjects/{subjects}/examinations/{examinations}/results', 'Subjects\SubjectExaminationsController@showExamResults');
        Route::resource('subjects/{subjects}/examinations',     'Subjects\SubjectExaminationsController', ['except' => ['destroy']]);
        
        Route::get('subjects/{subjects}/details',               'Subjects\SubjectsController@showDetails');
        Route::get('subjects/{subjects}',                       'Subjects\SubjectsController@show');
    });

    /*
     * Routes of pages handling the question bank, including categories, topics, and subtopics
     */
    Route::group(['middleware' => ['role:Faculty']], function () {
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/create/{type}', 'Questions\QuestionsController@create');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/create/{type}', 'Questions\QuestionsController@store');
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/instance', 'Questions\QuestionsController@generateInstance');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/instance/results', 'Questions\QuestionsController@processInstance');
        Route::resource('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions', 'Questions\QuestionsController', ['except' => ['index', 'create', 'destroy']]);

        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/delete',   'Questions\QuestionSubtopicsController@showDeleteConfirmation');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/delete',  'Questions\QuestionSubtopicsController@delete');
        Route::resource('categories/{categories}/topics/{topics}/subtopics', 'Questions\QuestionSubtopicsController', ['except' => ['index', 'destroy']]);         
        
        Route::get('categories/{categories}/topics/{topics}/delete',   'Questions\QuestionTopicsController@showDeleteConfirmation');
        Route::post('categories/{categories}/topics/{topics}/delete',  'Questions\QuestionTopicsController@delete');
        Route::resource('categories/{categories}/topics', 'Questions\QuestionTopicsController', ['except' => ['index', 'destroy']]);    
        
        Route::get('categories/{categories}/delete',   'Questions\QuestionCategoriesController@showDeleteConfirmation');
        Route::post('categories/{categories}/delete',  'Questions\QuestionCategoriesController@delete');    
        Route::get('categories/subjects/{url}',   'Questions\QuestionCategoriesController@indexFrom');
        Route::resource('categories', 'Questions\QuestionCategoriesController', ['except' => 'destroy']);
    });

    /*
     * Routes of pages concerning student classes and their components
     */
    Route::group(['middleware' => ['role:Student']], function () {
        Route::get('classes/{classes}', 'ClassesController@show');
    });
    
    /*
     * Routes of pages covering file downloads
     */
    Route::post('download', 'FilesController@download');
    Route::get('files/{files}', 'FilesController@viewDownloadHistory');
});

