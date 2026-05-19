<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', [ChirpController::class, 'index']);
Route::post('/chirps', [ChirpController::class, 'store']);
Route::get('/chirps/{chirp}/edit',[ChirpController::class, 'edit']);
Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);

//Registration Routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', RegisterController::class)
    ->middleware('guest');
Route::post('/logout',LogoutController::class)
    ->middleware('auth');