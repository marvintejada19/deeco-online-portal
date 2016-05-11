<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('articles', function($id){
            return \App\Models\Article::findOrFail($id);
        });

        $router->bind('subjects', function($id){
            return \App\Models\Subjects\Subject::findOrFail($id);
        });

        $router->bind('classes', function($id){
            return \App\Models\Subjects\Subject::findOrFail($id);
        });

        $router->bind('posts', function($id){
            return \App\Models\Subjects\SubjectPost::findOrFail($id);
        });

        $router->bind('requirements', function($id){
            return \App\Models\Subjects\SubjectRequirement::findOrFail($id);
        });

        $router->bind('examinations', function($id){
            return \App\Models\Subjects\SubjectExamination::findOrFail($id);
        });

        $router->bind('instances', function($id){
            return \App\Models\Subjects\SubjectExaminationInstance::findOrFail($id);
        });

        $router->bind('categories', function($name){
            return \App\Models\Questions\QuestionCategory::where('name', $name)->firstOrFail();
        });

        $router->bind('questions', function($id){
            return \App\Models\Questions\Question::findOrFail($id);
        });

        $router->bind('files', function($id){
            return \App\Models\File::findOrFail($id);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
