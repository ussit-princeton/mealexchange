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

Route::get('/','App\Http\Controllers\HomeController@index');


Route::resource('reservation','App\Http\Controllers\ReservationController');
Route::resource('locations', 'App\Http\Controllers\LocationController');
Route::resource('checkin', 'App\Http\Controllers\CheckinController');
Route::resource('approval', 'App\Http\Controllers\ApprovalController');
Route::resource('capacity','App\Http\Controllers\CapacityController');
