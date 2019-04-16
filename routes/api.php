<?php

use Illuminate\Http\Request;

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
    Route::post('login', 'AuthController@login');

//    Route::group(['middleware' => 'auth:api'], function () {
//        Route::get('logout', 'AuthController@logout');
//    });
});

Route::post('/alumni/register', 'AlumniRegistrationController@store');
Route::post('/alumni/set-username', 'AlumniRegistrationController@setUsername');


Route::post('/news/create', 'NewsController@store');
Route::post('/blog/create', 'BlogController@store');
Route::post('/event/create', 'EventController@store');
Route::post('/event-type/create', 'EventTypeController@store');
Route::post('/data-collection/create', 'AlumniDataCollectionController@store');

Route::get('/alumni', 'AlumniRegistrationController@index');
Route::get('/alumni/{alumni}', 'AlumniRegistrationController@show');
Route::patch('/alumni/confirm/{alumni}', 'AlumniRegistrationController@update');

