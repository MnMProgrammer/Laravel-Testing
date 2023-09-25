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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', 'App\Http\Controllers\ProjectsController@index');
Route::get('/projects/{project}', 'App\Http\Controllers\ProjectsController@show');

Route::post('/projects', 'App\Http\Controllers\ProjectsController@store');