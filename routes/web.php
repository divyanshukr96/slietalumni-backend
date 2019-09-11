<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('confirm', function () {
    return redirect('/registration/confirmation?token='.request()->get('token'));
})->name('confirm');


route::get('test', function () {
    $data = (object)[
        'name' => 'Divyanshu',
        'email' => 'jhgfd'
    ];

//    return new App\Mail\RegistrationSuccess(App\Registration::first());
    return (new App\Notifications\RegistrationSuccess(App\Registration::first()))->toMail('test@gmail.com')->render();

//
    $message = (new \App\Notifications\RegistrationConfirmation(App\Registration::first(), 'askdkjags'))->toMail('test@email.com');
    return $message->render();

});
