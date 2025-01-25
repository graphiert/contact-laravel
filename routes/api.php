<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

// AuthController
Route::post('/token', [AuthController::class, 'token'])
    ->middleware('header.json');
Route::post('/revoke', [AuthController::class, 'revoke'])
    ->middleware(['header.json', 'auth:sanctum']);

Route::apiResource('/contacts', ContactController::class)
    ->middleware(['header.json', 'auth:sanctum']);
