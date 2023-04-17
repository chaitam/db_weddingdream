<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('customers', App\Http\Controllers\Api\CustomerController::class);

Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
Route::post('/users/create', [UserController::class, 'store']);
Route::get("/users/get/{email}", [UserController::class, 'show']);
Route::apiResource('vendors', App\Http\Controllers\Api\VendorController::class);

Route::apiResource('konsultans', App\Http\Controllers\Api\KonsultanController::class);

Route::apiResource('talents', App\Http\Controllers\Api\TalentController::class);

Route::apiResource('produks', App\Http\Controllers\Api\ProdukController::class);


// Route::get('/customers', CustomerController::class);
// Route::post('/customers/{customer}', CustomerController::class);
// Route::delete('/customers/{customer}', CustomerController::class);
