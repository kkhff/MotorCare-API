<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MotorcycleController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
        })->middleware('auth:sanctum');

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/delete', [AuthController::class, 'destroy']);

    Route::apiResource('motorcycle', MotorcycleController::class);
});
