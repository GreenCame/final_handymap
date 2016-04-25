<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', function () {if (Auth::check()){return view('map');} else{return view('welcome');}});
    Route::get('/auth', function () {return redirect("/map");});
    Route::get('auth/facebook', 'Auth\AuthFacebookController@redirectToProvider');
    Route::get('auth/facebook/callback', 'Auth\AuthFacebookController@handleProviderCallback');

    Route::get('/profile', 'UserController@getProfile')->middleware('auth');
    Route::get('/contribution/{pseudo}', 'PointController@showContribution')->middleware('auth');
    Route::put('/settings', 'UserController@postSettings')->middleware('auth');
    Route::get('/settings', 'UserController@getSettings')->middleware('auth');
    Route::get('/settings/{id}', 'AdminController@getSettingsUser')->middleware('admin');

    Route::get('/map', 'HomeController@index')->middleware('auth');
    Route::get('/feedback', 'HomeController@feedback')->middleware('auth');
    Route::post('/feedback', 'HomeController@postFeedback')->middleware('auth');

    Route::get('/console', 'AdminController@getConsole')->middleware('admin');

    //API
    //users api
    Route::get('/api/users/get','AdminController@getUsers')->middleware('admin');
    Route::get('/api/users/put/{id}','AdminController@putUser')->middleware('admin');
    Route::get('/api/users/delete/{id}','AdminController@deleteUser')->middleware('admin');
    //feedback api
    Route::get('/api/feedbacks/get','AdminController@getFeedbacks')->middleware('admin');
    Route::get('/api/feedbacks/put/{id}','AdminController@putFeedback')->middleware('admin');
    Route::get('/api/feedbacks/delete/{id}','AdminController@deleteFeedback')->middleware('admin');
    //Point api
    Route::get('/api/waiting_points/get','AdminController@getWaitingPoints')->middleware('admin');
    Route::get('/api/points/add','PointController@addPoint')->middleware('auth');
    Route::get('/api/points/get','PointController@getPoints')->middleware('auth');
    Route::get('/api/points/get/type/{type}','PointController@getTypeToPicture')->middleware('auth');
    Route::get('/api/points/get/{user}','PointController@getContribution')->middleware('auth');
    Route::get('/api/points/put/{id}','AdminController@putPoint')->middleware('admin');
    Route::get('/api/points/delete/{id}','PointController@deletePoint')->middleware('auth');
    //Chat api
    Route::get('/chatroom', 'ChatController@index');
    Route::post('chatroom/push', 'ChatController@push');
    Route::post('chatroom/report', 'ChatController@report');
    Route::get('chatroom/push', 'ChatController@push');
});
