<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Provide controller methods with object instead of ID
Route::model('tasks', 'Task');
Route::model('projects', 'Project');

Route::resource('projects', 'ProjectsController');
// Route::resource('tasks', 'TasksController');
Route::resource('projects.tasks', 'TasksController');

// Use slugs rather than IDs in URLs
Route::bind('tasks', function($value, $route) {
	return App\Task::whereSlug($value)->first();
});
Route::bind('projects', function($value, $route) {
	return App\Project::whereSlug($value)->first();
});

Route::get('/', function () {
    return view('misc/index');
});

Route::get('/portfolio', function () {
    return view('misc/portfolio');
});

Route::get('/resume', function () {
    return view('misc/resume');
});

Route::get('/portfolio/assembly', function () {
    return view('demos/assembly');
});

Route::get('/portfolio/android-fragments', function () {
    return view('demos/android-fragments');
});

Route::get('/portfolio/matching-game', function () {
    return view('demos/matching-game');
});


// Route::get('/', function()
// {
//     return 'Hello World';
// });