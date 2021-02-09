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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('signup', 'Auth\AuthController@signup');
    Route::post('password/email', 'Auth\ForgotPasswordController@forgotPasswordSendToken');
    Route::post('password/reset', 'Auth\ForgotPasswordController@passwordReset');
    Route::post('users/signup/invitation', 'Auth\InviteController@signUpInvitedUser');
    Route::post('users/invitation', 'Auth\InviteController@acceptProjectInvitation');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'Auth\AuthController@user');
        Route::get('logout', 'Auth\AuthController@logout');
        Route::post('invite', 'Auth\InviteController@sendInvitationLink');

        // ---------------- Project ----------------
        Route::get('/projects', 'ProjectController@index');
        Route::get('projects/{project}', 'ProjectController@show');
        Route::post('/projects', 'ProjectController@store');
        Route::get('projects/{project}/edit', 'ProjectController@edit');
        Route::put('projects/{project}', 'ProjectController@update');
        Route::get('projects/{project}/delete', 'ProjectController@delete');   
        
        // ----------------        ----------------

        // ---------------- Epic ----------------
        Route::post('epics', 'EpicController@store');
        Route::get('epics/{epic}', 'EpicController@show');
        Route::get('epics/{epic}/edit', 'EpicController@edit');
        Route::get('epics/{epic}/reset-status', 'EpicController@resetStatus');
        Route::put('epics/{epic}', 'EpicController@update');
        Route::get('epics/{epic}/delete', 'EpicController@delete');
        // ----------------        ----------------

        // ---------------- User-Stories ----------------
        Route::get('user-stories/{userStory}', 'UserStoryController@show');
        Route::get('user-stories/{userStory}/edit', 'UserStoryController@edit');
        Route::put('user-stories/{userStory}', 'UserStoryController@update');
        Route::get('user-stories/{userStory}/delete', 'UserStoryController@delete');
        // ----------------        ----------------

        // ---------------- Project-Dashboard ----------------
        Route::get('/projects/{project}/dashboard/user-story-priority', 'DashboardController@getPriorityChartData');
        Route::get('/projects/{project}/dashboard/user-story-value', 'DashboardController@getValueChartData');
        Route::get('/projects/{project}/dashboard/user-story-risk', 'DashboardController@getRiskChartData');
        Route::get('/projects/{project}/dashboard/strategic-user-stories', 'DashboardController@getStrategicUserStoriesDescription');
        Route::get('/projects/{project}/dashboard/user-stories-count', 'DashboardController@getProjectUserStoriesCount');
        
        
        
        
        
        
    });
});
