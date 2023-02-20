<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RefreshTokenController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class)->middleware('auth2');
Route::post('login', LoginController::class);
Route::post('refresh-token', RefreshTokenController::class);
