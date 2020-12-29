<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.layout');
});

Route::get('/projects', 'ProjectController@index');
Route::get('projects/{project}/edit', 'ProjectController@edit');

Route::get('/projects/create', 'ProjectController@create');
Route::get('/signup', function(){
    return view('auth.signup');
});

Route::get('/login', function(){
    return view('auth.login');
});

Route::get('/password/reset', function(){
    return view('auth.passwords.forgotPassword');
});

Route::view('forgot_password', 'auth.passwords.resetPassword')->name('password.reset');
