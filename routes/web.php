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


//Auth::routes();

Route::get('confirm', function () {
    return redirect('/registration/confirmation?token=' . request()->get('token'));
})->name('confirm');

Route::get('{all?}', function () {
    return view('welcome');
})->where('all', '.+');

Route::get('password/reset/{token}', function ($token) {
    return redirect("/password/reset?token=$token");
})->name('password.reset');



//route::get('test', function () {
//    $data = (object)[
//        'name' => 'Divyanshu',
//        'email' => 'jhgfd'
//    ];

//    return new App\Mail\RegistrationSuccess(App\Registration::first());
//    return (new App\Notifications\RegistrationSuccess(App\Registration::first()))->toMail('test@gmail.com')->render();

//    return (new App\Notifications\MeetRegistration(App\AlumniMeet::first()))->toMail('test@gmail.com')->render();

//
//    return (new \App\Notifications\RegistrationConfirmation(App\Registration::first(), 'askdkjags'))->toMail('test@email.com')->render();
//    return (new App\Notifications\MeetConfirmation(App\AlumniMeet::first()))->toMail('test@gmail.com')->render();

//});
