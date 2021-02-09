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
    return view('auth.login');
});

Route::get('/projects{any}', function(){
    return view('projects.index');
})->where('any', '.*');



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
Route::view('users/invitation/', 'auth.invitations.acceptProjectInvitation')->name('existingUserInvitation');

Route::view('forgot_password', 'auth.passwords.resetPassword')->name('password.reset');
