<?php

use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
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

Route::get('{any}', function () {
    return view('app');
})->where('any','.*');


Route::get('/client_interventions', 'InterventionController@getClientInterventions')->name('client_interventions');

Route::get('/users/{name_society}', function () {
    // Nothing
})->name('users');

Route::get('/reset-password', function () {
    // Nothing
})->name('reset-password');

