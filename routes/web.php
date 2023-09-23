<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [CustomerController::class, 'index']);
Route::get('/detail/{id}', [CustomerController::class, 'show']);
Route::post('/store', [CustomerController::class, 'store']);
Route::patch('/update/{id}', [CustomerController::class, 'update']);
Route::delete('/delete/{id}', [CustomerController::class, 'delete']);

Route::post('/addresses', [AddressController::class, 'addresses']);
Route::patch('/addresses/update/{id}', [AddressController::class, 'update']);
Route::delete('/addresses/delete/{id}', [AddressController::class, 'delete']);

