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
    Route::get('/', 'AuthController@check')->middleware('auth:api');
    Route::post('login', 'AuthController@login');

//    Route::group(['middleware' => 'auth:api'], function () {
//        Route::get('logout', 'AuthController@logout');
//    });
});

Route::post('/alumni/register', 'AlumniRegistrationController@store');
Route::post('/alumni/set-username', 'AlumniRegistrationController@setUsername');


Route::apiResources([
    'roles' => 'RoleController',
    'permissions' => 'PermissionController',
    'users' => 'UserController',
    'event-type' => 'API\EventTypeController',
    'featured-alumni' => 'API\FeaturedAlumniController',
    'alumni-data' => 'AlumniDataCollectionController',
]);

Route::apiResources([
    'news' => 'API\NewsController',
    'events' => 'API\EventController',
],['except' => ['update']]);

Route::post('news/{news}','API\NewsController@update')->name('news.update');
Route::patch('news/{news}/publish','API\NewsController@publish')->name('news.publish');
Route::post('events/{event}','API\EventController@update')->name('events.update');
Route::patch('events/{event}/publish','API\EventController@publish')->name('events.publish');

Route::post('/blog/create', 'BlogController@store');

//Route::get('/event-type', 'API\EventTypeController@index');
//Route::post('/event-type/create', 'API\EventTypeController@store');

Route::get('/alumni', 'AlumniRegistrationController@index');
Route::get('/alumni/{alumni}', 'AlumniRegistrationController@show');
Route::patch('/alumni/confirm/{alumni}', 'AlumniRegistrationController@update');

Route::get('/alumni/related/{alumni}', 'AlumniRegistrationController@related');

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});

