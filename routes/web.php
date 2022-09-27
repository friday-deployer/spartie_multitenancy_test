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
Route::domain(env('CENTRAL_DOMAIN'))->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });
});


//tenant routes
Route::middleware('tenant')->group(function () {
    Route::get('/', function () {
        return view('tenant.welcome');
    });


    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
