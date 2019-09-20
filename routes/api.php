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
    Route::get('carousel', 'PublicController@carousel');
    Route::get('events', 'PublicController@events');
    Route::get('featured-alumni', 'PublicController@featuredAlumni');
    Route::get('news-stories', 'PublicController@newsAndStories');
});

Route::post('contact', 'API\ContactController@store');
Route::post('donation', 'API\DonationController@store');
Route::post('meet/register', 'API\AlumniMeetController@store');


Route::post('/alumni/register', 'RegistrationController@store');
Route::post('/set-username', 'RegistrationController@setUsername');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () { // middleware are set in the controller
    Route::get('/', 'AuthController@check');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    Route::get('profile', 'AuthController@profile');
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'roles' => 'RoleController',
        'permissions' => 'PermissionController',
        'users' => 'UserController',
        'event-type' => 'API\EventTypeController',
        'featured-alumni' => 'API\FeaturedAlumniController',
        'alumni-data' => 'DataCollectionController',
        'carousel' => 'API\CarouselController',
        'news' => 'API\NewsController',
        'events' => 'API\EventController',
    ]);

    Route::apiResource('donation', 'API\DonationController')->except('store');
    Route::apiResource('contact', 'API\ContactController')->except('store');
    Route::patch('news/{news}/publish', 'API\NewsController@publish')->name('news.publish');
    Route::patch('events/{event}/publish', 'API\EventController@publish')->name('events.publish');

    Route::get('/alumni', 'RegistrationController@index');
    Route::get('/alumni/{alumni}', 'RegistrationController@show');
    Route::patch('/alumni/confirm/{alumni}', 'RegistrationController@update');
    Route::get('/alumni/related/{alumni}', 'RegistrationController@related');

});


//Route::post('/blog/create', 'BlogController@store');

//Route::get('/event-type', 'API\EventTypeController@index');
//Route::post('/event-type/create', 'API\EventTypeController@store');


Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});

