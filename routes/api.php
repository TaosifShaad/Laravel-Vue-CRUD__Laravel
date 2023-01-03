<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MediaController;
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

Route::middleware('auth:sanctum')->prefix('/')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/save', [EmployeeController::class, 'store']);
    Route::put('/update/{id}', [EmployeeController::class, 'update']);
    Route::delete('/delete/{id}', [EmployeeController::class, 'destroy']);
});

Route::post('/upload', [MediaController::class, 'upload'])->name('upload');

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::post('delete', 'deleteAcc')->middleware('auth:sanctum');
    Route::post('updateProfile', 'updateProfile')->middleware('auth:sanctum');
});
