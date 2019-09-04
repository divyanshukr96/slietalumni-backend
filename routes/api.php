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

Route::group(['prefix' => "public"], function () {
    Route::get('carousel','PublicController@carousel');
    Route::post('contact', 'API\ContactController@store');
});

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

Route::post('/alumni/register', 'RegistrationController@store');
Route::post('/alumni/set-username', 'RegistrationController@setUsername');


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'roles' => 'RoleController',
        'permissions' => 'PermissionController',
        'users' => 'UserController',
        'event-type' => 'API\EventTypeController',
        'featured-alumni' => 'API\FeaturedAlumniController',
        'alumni-data' => 'DataCollectionController',
        'donation' => 'API\DonationController',
        'carousel' => 'API\CarouselController',
    ]);
});

Route::apiResource('contact','API\ContactController')->except('store');

Route::apiResources([
    'news' => 'API\NewsController',
    'events' => 'API\EventController',
], ['except' => ['update']]);

Route::post('news/{news}', 'API\NewsController@update')->name('news.update');
Route::patch('news/{news}/publish', 'API\NewsController@publish')->name('news.publish');
Route::post('events/{event}', 'API\EventController@update')->name('events.update');
Route::patch('events/{event}/publish', 'API\EventController@publish')->name('events.publish');

Route::post('/blog/create', 'BlogController@store');

//Route::get('/event-type', 'API\EventTypeController@index');
//Route::post('/event-type/create', 'API\EventTypeController@store');

Route::get('/alumni', 'RegistrationController@index');
Route::get('/alumni/{alumni}', 'RegistrationController@show');
Route::patch('/alumni/confirm/{alumni}', 'RegistrationController@update')->middleware('auth:api');

Route::get('/alumni/related/{alumni}', 'RegistrationController@related');

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});

