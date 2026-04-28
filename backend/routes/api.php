<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MotorcycleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaintenancePartController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
        })->middleware('auth:sanctum');

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/delete', [AuthController::class, 'destroy']);

    Route::post('/part/{id}/replace', [MaintenancePartController::class, 'replace']);
    Route::apiResource('motorcycle', MotorcycleController::class);
    Route::apiResource('part', MaintenancePartController::class);
});
