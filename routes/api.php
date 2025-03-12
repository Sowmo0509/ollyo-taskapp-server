<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Apply the sanctum middleware to the tasks routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
