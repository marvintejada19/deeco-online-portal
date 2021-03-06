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
    Route::get('/', 'WelcomeController@index');

    /*
     * Routes of pages covering login authentication and password
     */
    Route::auth();
    Route::get('home', 'HomeController@index');
    Route::get('password/change', 'Auth\PasswordController@showPasswordChangeForm');
    Route::post('password/change', 'Auth\PasswordController@changePassword');

    /*
     * Routes of pages covering admin pages
     */
    Route::group(['middleware' => ['role:System Administrator']], function () {
        Route::get('users/deactivate/{users}', 'UsersController@deactivateUser');
        Route::get('users/activate/{users}', 'UsersController@activateUser');
        Route::post('users/enrollment', 'UsersController@postSearch');
        Route::get('users/enrollment', 'UsersController@enrollment');
        Route::post('users/enrollment/enroll', 'UsersController@enroll');
        Route::get('users/school-management', 'UsersController@indexOfSchoolManagement');
        Route::get('users/faculty', 'UsersController@indexOfFaculty');
        Route::get('users/students', 'UsersController@indexOfStudents');
        Route::resource('users', 'UsersController', ['only' => ['create', 'store', 'edit', 'update']]);

        Route::post('faculty-loadings/assignment', 'AdminFunctionalities\FacultyLoadingsController@postSearch');
        Route::get('faculty-loadings/assignment', 'AdminFunctionalities\FacultyLoadingsController@assignment');
        Route::post('faculty-loadings/assignment/assign', 'AdminFunctionalities\FacultyLoadingsController@assign');
        Route::get('faculty-loadings/{users}', 'AdminFunctionalities\FacultyLoadingsController@show');
        Route::resource('faculty-loadings', 'AdminFunctionalities\FacultyLoadingsController', ['only' => ['index']]);

        Route::post('grade-sections/subjects/assignment', 'AdminFunctionalities\GradeSectionsController@postSearch');
        Route::get('grade-sections/subjects/assignment', 'AdminFunctionalities\GradeSectionsController@assignment');
        Route::post('grade-sections/subjects/assignment/assign', 'AdminFunctionalities\GradeSectionsController@assign');
        Route::resource('grade-sections', 'AdminFunctionalities\GradeSectionsController', ['only' => ['index', 'show']]);

        Route::resource('others/subjects', 'AdminFunctionalities\SubjectsController', ['only' => ['index', 'create', 'store']]);
        Route::resource('others/school-years', 'AdminFunctionalities\SchoolYearsController', ['only' => ['create', 'store']]);
        
        // Route::get('articles/list', 'ArticlesController@list');
        // Route::resource('articles', 'ArticlesController', ['except' => ['destroy']]);
    });

    /*
     * Routes of pages handling the subjects, subject posts, subject requirements, and examinations
     */
    Route::group(['middleware' => ['role:Faculty']], function () {
        Route::post('posts/{posts}/attach/{id}/delete', 'GradeSectionSubjectContents\PostsController@deleteAssignment');
        Route::get('posts/{posts}/attach/{id}/delete', 'GradeSectionSubjectContents\PostsController@confirmDeleteAssignment');
        Route::post('posts/{posts}/attach/{id}/', 'GradeSectionSubjectContents\PostsController@updateAssignment');
        Route::get('posts/{posts}/attach/{id}/edit', 'GradeSectionSubjectContents\PostsController@editAssignment');
        Route::get('posts/{posts}/attach', 'GradeSectionSubjectContents\PostsController@assignment');
        Route::post('posts/{posts}/attach', 'GradeSectionSubjectContents\PostsController@assign');
        Route::resource('posts', 'GradeSectionSubjectContents\PostsController', ['except' => ['destroy']]);
        
        Route::post('requirements/{requirements}/attach/{id}/delete', 'GradeSectionSubjectContents\RequirementsController@deleteAssignment');
        Route::get('requirements/{requirements}/attach/{id}/delete', 'GradeSectionSubjectContents\RequirementsController@confirmDeleteAssignment');
        Route::post('requirements/{requirements}/attach/{id}/', 'GradeSectionSubjectContents\RequirementsController@updateAssignment');
        Route::get('requirements/{requirements}/attach/{id}/edit', 'GradeSectionSubjectContents\RequirementsController@editAssignment');
        Route::get('requirements/{requirements}/attach', 'GradeSectionSubjectContents\RequirementsController@assignment');
        Route::post('requirements/{requirements}/attach', 'GradeSectionSubjectContents\RequirementsController@assign');
        Route::resource('requirements', 'GradeSectionSubjectContents\RequirementsController', ['except' => ['destroy']]);

        Route::get('examinations/{examinations}/parts/{parts}/items/{item_id}/delete', 'Examinations\ExaminationPartItemsController@showDeleteConfirmation');
        Route::post('examinations/{examinations}/parts/{parts}/items/{item_id}/delete', 'Examinations\ExaminationPartItemsController@delete');
        Route::post('examinations/{examinations}/parts/{parts}/items/create', 'Examinations\ExaminationPartItemsController@postCreateSearch');
        Route::resource('examinations/{examinations}/parts/{parts}/items', 'Examinations\ExaminationPartItemsController', ['except' => ['index', 'destroy']]);

        Route::get('examinations/{examinations}/parts/{parts}/delete', 'Examinations\ExaminationPartsController@showDeleteConfirmation');
        Route::post('examinations/{examinations}/parts/{parts}/delete', 'Examinations\ExaminationPartsController@delete');
        Route::resource('examinations/{examinations}/parts', 'Examinations\ExaminationPartsController', ['except' => ['destroy']]);

        Route::group(['middleware' => ['checkExaminationQuestions']], function () {
            Route::get('examinations/{examinations}/instances', 'Examinations\FacultyExaminationInstancesController@showInstanceConfirmation');
            Route::post('examinations/{examinations}/faculty/instances', 'Examinations\FacultyExaminationInstancesController@createExaminationInstance');
            Route::get('examinations/{examinations}/faculty/instances/{instances}/page/finish', 'Examinations\FacultyExaminationInstancesController@showExamFinishPage');
            Route::post('examinations/{examinations}/faculty/instances/{instances}/page/finish', 'Examinations\FacultyExaminationInstancesController@finish');
            Route::get('examinations/{examinations}/faculty/instances/{instances}/page/{page}', 'Examinations\FacultyExaminationInstancesController@showExamPage');
            Route::post('examinations/{examinations}/faculty/instances/{instances}/page/{page}', 'Examinations\FacultyExaminationInstancesController@processExamPage');
            Route::get('examinations/{examinations}/faculty/instances/{instances}/results', 'Examinations\FacultyExaminationInstancesController@showExamResults');
        
            Route::post('examinations/{examinations}/attach/{id}/delete', 'Examinations\ExaminationsController@deleteAssignment');
            Route::get('examinations/{examinations}/attach/{id}/delete', 'Examinations\ExaminationsController@confirmDeleteAssignment');
            Route::post('examinations/{examinations}/attach/{id}/', 'Examinations\ExaminationsController@updateAssignment');
            Route::get('examinations/{examinations}/attach/{id}/edit', 'Examinations\ExaminationsController@editAssignment');
            Route::get('examinations/{examinations}/attach', 'Examinations\ExaminationsController@attachment');
            Route::post('examinations/{examinations}/attach', 'Examinations\ExaminationsController@attach');
        });

        Route::resource('examinations', 'Examinations\ExaminationsController', ['except' => ['destroy']]);
        
        Route::get('subjects/{subjects}/student-results/{deployments}/instances/{instances}', 'Examinations\ExaminationsController@showStudentResults');
        Route::get('subjects/{subjects}/student-results/{deployments}', 'Examinations\ExaminationsController@showResultsIndex');
        Route::get('subjects/{subjects}/requirements/{subject_requirements}/submissions', 'GradeSectionSubjectContents\RequirementsController@showStudentSubmissions');
        Route::get('subjects/{subjects}/class-record', 'GradeSectionSubjectsController@showClassRecord');
        Route::get('subjects/{subjects}/details', 'GradeSectionSubjectsController@showDetails');
        Route::get('subjects/{subjects}', 'GradeSectionSubjectsController@show');
        
    });

    /*
     * Routes of pages handling the question bank, including categories, topics, and subtopics
     */
    Route::group(['middleware' => ['role:Faculty']], function () {
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/multiple-choice/choices/{id}/edit', 'Questions\QuestionMultipleChoiceController@edit');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/multiple-choice/choices/{id}/', 'Questions\QuestionMultipleChoiceController@update');

        Route::post('remove-choice/match-columns/{id}', 'Questions\QuestionMatchColumnsController@removeChoice');
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/match-column-a-with-column-b/items/create', 'Questions\QuestionMatchColumnsController@createItem');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/match-column-a-with-column-b/items/', 'Questions\QuestionMatchColumnsController@storeItem');
        
        Route::post('remove-choice/select-wordbox/{id}', 'Questions\QuestionSelectFromTheWordboxController@removeChoice');
        Route::post('remove-item/select-wordbox/{id}', 'Questions\QuestionSelectFromTheWordboxController@removeItem');
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/select-from-the-wordbox/choices/create', 'Questions\QuestionSelectFromTheWordboxController@createChoice');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/select-from-the-wordbox/choices', 'Questions\QuestionSelectFromTheWordboxController@storeChoice');
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/select-from-the-wordbox/items/create', 'Questions\QuestionSelectFromTheWordboxController@createItem');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/select-from-the-wordbox/items', 'Questions\QuestionSelectFromTheWordboxController@storeItem');

        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/create/{type}/step-2', 'Questions\QuestionMultipleChoiceController@create');

        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/create/{type}', 'Questions\QuestionsController@create');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/create/{type}', 'Questions\QuestionsController@store');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/move/do',  'Questions\QuestionsController@move');
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/move',   'Questions\QuestionsController@showMoveConfirmation');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/move',  'Questions\QuestionsController@postSearch');
        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/delete',   'Questions\QuestionsController@showDeleteConfirmation');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{questions}/delete',  'Questions\QuestionsController@delete');
        Route::resource('categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions', 'Questions\QuestionsController', ['except' => ['index', 'create', 'destroy']]);

        Route::get('categories/{categories}/topics/{topics}/subtopics/{subtopics}/delete',   'Questions\QuestionSubtopicsController@showDeleteConfirmation');
        Route::post('categories/{categories}/topics/{topics}/subtopics/{subtopics}/delete',  'Questions\QuestionSubtopicsController@delete');
        Route::resource('categories/{categories}/topics/{topics}/subtopics', 'Questions\QuestionSubtopicsController', ['except' => ['index', 'destroy']]);         
        
        Route::get('categories/{categories}/topics/{topics}/delete',   'Questions\QuestionTopicsController@showDeleteConfirmation');
        Route::post('categories/{categories}/topics/{topics}/delete',  'Questions\QuestionTopicsController@delete');
        Route::resource('categories/{categories}/topics', 'Questions\QuestionTopicsController', ['except' => ['index', 'destroy']]);    
        
        Route::get('categories/{categories}/delete',   'Questions\QuestionCategoriesController@showDeleteConfirmation');
        Route::post('categories/{categories}/delete',  'Questions\QuestionCategoriesController@delete');    
        Route::resource('categories', 'Questions\QuestionCategoriesController', ['except' => 'destroy']);
    });

    /*
     * Routes of pages concerning student classes and their components
     */
    Route::group(['middleware' => ['role:Student', 'classEnrolled']], function () {
        Route::get('classes/{classes}', 'ClassesController@show');
        
        Route::get('classes/{classes}/requirements/{subject_requirements}/submission', 'ClassesController@showRequirementStatus');
        Route::post('classes/{classes}/requirements/{subject_requirements}/submission', 'ClassesController@submitRequirement');
        
        Route::get('classes/{classes}/deployments/{deployments}/instances', 'Examinations\ExaminationInstancesController@showInstanceConfirmation');
        Route::post('classes/{classes}/deployments/{deployments}/instances', 'Examinations\ExaminationInstancesController@createExaminationInstance');
        //Route::post('classes/{classes}/deployments/{deployments}/instances/timeUp', 'Examinations\ExaminationInstancesController@finishUpExam');
        Route::get('classes/{classes}/deployments/{deployments}/instances/{instances}/page/finish', 'Examinations\ExaminationInstancesController@showExamFinishPage');
        Route::post('classes/{classes}/deployments/{deployments}/instances/{instances}/page/finish', 'Examinations\ExaminationInstancesController@finish');
        Route::get('classes/{classes}/deployments/{deployments}/instances/{instances}/page/{page}', 'Examinations\ExaminationInstancesController@showExamPage');
        Route::post('classes/{classes}/deployments/{deployments}/instances/{instances}/page/{page}', 'Examinations\ExaminationInstancesController@processExamPage');
        Route::get('classes/{classes}/deployments/{deployments}/results', 'Examinations\ExaminationsController@showExamResults');
    });
    
    /*
     * Routes of pages covering file downloads
     */
    Route::post('download', 'FilesController@download');
    Route::get('files/download-history/{file_id}', 'FilesController@viewDownloadHistory');
});

