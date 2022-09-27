<?php

use Illuminate\Support\Facades\Route;

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


//main 
Route::domain(env('CENTRAL_DOMAIN'))->name('main.')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('front');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});


//tenant routes
Route::middleware('tenant')->name('tenant.')->group(function () {
    Route::get('/', function () {
        return view('tenant.welcome');
    });

    Route::get('login', 'App\Http\Controllers\Tenant\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'App\Http\Controllers\Tenant\Auth\LoginController@login')->name('login');

    Route::post('logout', 'App\Http\Controllers\Tenant\Auth\LoginController@logout')->name('logout');

    Route::get('register', 'App\Http\Controllers\Tenant\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'App\Http\Controllers\Tenant\Auth\RegisterController@register')->name('register');

    Route::get('password/confirm', 'App\Http\Controllers\Tenant\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'App\Http\Controllers\Tenant\Auth\ConfirmPasswordController@confirm')->name('password.confirm');
    Route::get('email/verify', 'App\Http\Controllers\Tenant\Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Tenant\Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'App\Http\Controllers\Tenant\Auth\VerificationController@resend')->name('verification.resend');




    Route::get('/home', [App\Http\Controllers\Tenant\HomeController::class, 'index'])->name('home');
});
