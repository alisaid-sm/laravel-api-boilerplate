<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\GetProfileController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class);
Route::post('refresh-token', RefreshTokenController::class);
Route::post('register', RegisterController::class)->middleware('auth2');
Route::get('profile', GetProfileController::class)->middleware('auth2');
