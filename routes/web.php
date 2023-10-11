<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::group(['middleware' => 'auth'], function() {
    Route::get('/projects', 'App\Http\Controllers\ProjectsController@index')->name('project.profile');
    Route::get('/projects/create', 'App\Http\Controllers\ProjectsController@create')->name('project.create');
    Route::get('/projects/{project}', 'App\Http\Controllers\ProjectsController@show')->name('project.show');
    Route::post('/projects', 'App\Http\Controllers\ProjectsController@store')->name('project.post');
    
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
