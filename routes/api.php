<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

// AuthController
Route::post('/token', [AuthController::class, 'token']);
Route::post('/revoke', [AuthController::class, 'revoke'])->middleware('auth:sanctum');

Route::apiResource('/contacts', ContactController::class)->middleware('auth:sanctum');
