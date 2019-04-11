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

Route::post('/news/create', 'NewsController@store');
Route::post('/blog/create', 'BlogController@store');
Route::post('/event/create', 'EventController@store');
Route::post('/event-type/create', 'EventTypeController@store');
Route::post('/data-collection/create', 'AlumniDataCollectionController@store');
Route::get('/alumni', 'AlumniRegistrationController@index');
Route::post('/alumni/register', 'AlumniRegistrationController@store');
