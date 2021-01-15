<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('signup', 'Auth\AuthController@signup');
    Route::post('password/email', 'Auth\ForgotPasswordController@forgotPasswordSendToken');
    Route::post('password/reset', 'Auth\ForgotPasswordController@passwordReset');
    Route::post('invite', 'Auth\InviteController@sendInvitationLink');
    Route::post('users/signup/invitation', 'Auth\InviteController@signUpInvitedUser');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'Auth\AuthController@user');
        Route::post('/projects', 'ProjectController@store');
        Route::get('/projects', 'ProjectController@index');
        Route::put('projects/{project}', 'ProjectController@update');
        Route::get('projects/{project}/delete', 'ProjectController@delete');   
        Route::get('logout', 'Auth\AuthController@logout');
        
        
        
    });
});
