<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MotorcycleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaintenancePartController;
use App\Http\Controllers\Api\TripController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
        });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/delete', [AuthController::class, 'destroy']);

    Route::post('/part/{id}/replace', [MaintenancePartController::class, 'replace']);
    Route::apiResource('motorcycle', MotorcycleController::class);
    Route::apiResource('trip', TripController::class);
    Route::apiResource('part', MaintenancePartController::class);
});
