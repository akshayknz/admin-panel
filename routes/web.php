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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/getBookings', [App\Http\Controllers\HomeController::class, 'booking']);
Route::post('/getClients', [App\Http\Controllers\HomeController::class, 'client']);
Route::post('/getCities', [App\Http\Controllers\HomeController::class, 'city']);
Route::post('/getStates', [App\Http\Controllers\HomeController::class, 'state']);
Route::post('/getAges', [App\Http\Controllers\HomeController::class, 'age']);
Route::post('/getRevenue', [App\Http\Controllers\HomeController::class, 'revenue']);

Auth::routes();
