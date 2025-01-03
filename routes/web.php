<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/contacts', ContactController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/token', [TokenController::class, 'create'])->name('token.create');
    Route::post('/token', [TokenController::class, 'store'])->name('token.store');
    Route::delete('/token/{id:int}', [TokenController::class, 'destroy'])->name('token.destroy');
});

require __DIR__.'/auth.php';
