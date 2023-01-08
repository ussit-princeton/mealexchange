<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::middleware('casauth')->group(function() {

    Route::get('/','App\Http\Controllers\HomeController@index');
    Route::resource('reservation','App\Http\Controllers\ReservationController');
    Route::resource('locations', 'App\Http\Controllers\LocationController')->middleware(['can:admin']);
    Route::resource('checkin', 'App\Http\Controllers\CheckinController')->middleware(['can:checker']);
    Route::resource('approval', 'App\Http\Controllers\ApprovalController');
    Route::resource('capacity','App\Http\Controllers\CapacityController')->middleware(['can:checker']);
    Route::resource('blackout', 'App\Http\Controllers\BlackoutController')->middleware(['can:checker']);
    Route::resource('history', 'App\Http\Controllers\ReportController')->middleware(['can:checker']);


});



