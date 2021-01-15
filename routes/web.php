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

Route::get('/projects', function () {
    return view('projects.index');
});

Route::get('logout', 'Auth\AuthController@logout');        

Route::group(['middleware' => ['auth:web', 'role:owner']], function() {
    Route::get('projects/{project}/edit', 'ProjectController@edit');        
});

Route::get('/projects/create', 'ProjectController@create');
Route::get('/signup', function(){
    return view('auth.signup');
});

Route::get('/login', function(){
    return view('auth.login');
})->name('login');

Route::get('/password/reset', function(){
    return view('auth.passwords.forgotPassword');
});

Route::get('/users/invite/', function(){
    return view('auth.invitations.inviteUser');
});

Route::view('users/signup/invitation/', 'auth.invitations.signupInvitedUser')->name('invitation');

Route::view('forgot_password', 'auth.passwords.resetPassword')->name('password.reset');
