<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoanPostApiController;
use Illuminate\Support\Facades\Route;

// Public API
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [LoanPostApiController::class, 'index']);
Route::get('/posts/{post}', [LoanPostApiController::class, 'show']);

// Protected API
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/posts', [LoanPostApiController::class, 'store']);
    Route::put('/posts/{post}', [LoanPostApiController::class, 'update']);
    Route::delete('/posts/{post}', [LoanPostApiController::class, 'destroy']);
    Route::patch('/posts/{post}/close', [LoanPostApiController::class, 'close']);
});