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
    Route::resource('reservation','App\Http\Controllers\ReservationController')->middleware(['can:user']);
    Route::resource('club', 'App\Http\Controllers\ClubController')->middleware(['can:user']);
    Route::resource('locations', 'App\Http\Controllers\LocationController')->middleware(['can:admin']);
    Route::resource('checkin', 'App\Http\Controllers\CheckinController')->middleware(['can:checker']);
    Route::resource('capacity','App\Http\Controllers\CapacityController')->middleware(['can:checker']);
    Route::resource('blackout', 'App\Http\Controllers\BlackoutController')->middleware(['can:checker']);
    Route::resource('history', 'App\Http\Controllers\ReportController')->middleware(['can:checker']);
    Route::get('/logout', 'App\Http\Controllers\LogoutController@index');

    Route::resource('graphs', 'App\Http\Controllers\GraphController')->middleware(['can:admin']);



});
Route::resource('approval', 'App\Http\Controllers\ApprovalController')->middleware('approvalauth');



