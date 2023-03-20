<?php

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

// Route::get('/customers', function () {
//     return view('customers.index');
// });

Route::apiResource('customers', App\Http\Controllers\Api\CustomerController::class);

Route::apiResource('users', App\Http\Controllers\Api\UserController::class);

Route::apiResource('vendors', App\Http\Controllers\Api\VendorController::class);

Route::apiResource('konsultans', App\Http\Controllers\Api\KonsultanController::class);

Route::apiResource('talents', App\Http\Controllers\Api\TalentController::class);

Route::apiResource('produks', App\Http\Controllers\Api\ProdukController::class);


