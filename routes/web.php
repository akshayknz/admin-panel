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
Route::get('/getCooks', [App\Http\Controllers\HomeController::class, 'cook']);
Route::post('/getLeaders', [App\Http\Controllers\HomeController::class, 'leader']);
Route::post('/getSalesteam', [App\Http\Controllers\HomeController::class, 'salesteam']);


Route::get('/revenue', function () {
    return view('revenue');
})->name('revenue')->middleware('permission:view tth data');
Route::post('/getRevenue', [App\Http\Controllers\HomeController::class, 'revenue']);
Route::get('/TTHData', function () {
    return view('tthData');
})->name('TTHData')->middleware('permission:view tth data');
Route::post('/getTthdata', [App\Http\Controllers\HomeController::class, 'tthdata']);

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/getUsers', [App\Http\Controllers\UserController::class, 'list']);
Route::get('/editUsers', [App\Http\Controllers\UserController::class, 'edit']);
Route::post('/updateUser', [App\Http\Controllers\UserController::class, 'update']);
Route::post('/createUser', [App\Http\Controllers\UserController::class, 'create']);
Route::delete('/deleteUser/{id}', [App\Http\Controllers\UserController::class, 'delete']);

Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
Route::get('/getRoles', [App\Http\Controllers\RoleController::class, 'list']);
Route::get('/getPermissions', [App\Http\Controllers\RoleController::class, 'listPermissions']);
Route::get('/editRole', [App\Http\Controllers\RoleController::class, 'edit']);
Route::post('/updateRole', [App\Http\Controllers\RoleController::class, 'update']);
Route::post('/createRole', [App\Http\Controllers\RoleController::class, 'create']);
Route::delete('/deleteRole/{id}', [App\Http\Controllers\RoleController::class, 'delete']);

Route::get('/test', [App\Http\Controllers\HomeController::class, 'test']);

Auth::routes();
