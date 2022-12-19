<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/employees', [EmployeeController::class, 'index'])->middleware('auth:sanctum');
Route::post('/save', [EmployeeController::class, 'store'])->middleware('auth:sanctum');
Route::put('/update/{id}', [EmployeeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/delete/{id}', [EmployeeController::class, 'destroy'])->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    // Route::post('logout', 'logout')->middleware('auth:sanctum');
});
