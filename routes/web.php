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

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/projects', 'App\Http\Controllers\ProjectsController@index')->middleware(['auth'])->name('project.profile');
Route::get('/projects/{project}', 'App\Http\Controllers\ProjectsController@show')->middleware(['auth'])->name('project.show');
Route::post('/projects', 'App\Http\Controllers\ProjectsController@store')->middleware(['auth'])->name('project.post');

require __DIR__.'/auth.php';
