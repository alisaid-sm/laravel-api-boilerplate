<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\GetProfileController;
use App\Http\Controllers\Auth\UpdateProfileController;
use App\Http\Controllers\Auth\GetUsersController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class);
Route::post('refresh-token', RefreshTokenController::class);
Route::post('register', RegisterController::class)->middleware('auth2');
Route::get('profile', GetProfileController::class)->middleware('auth2');
Route::patch('profile', UpdateProfileController::class)->middleware('auth2');
Route::get('users', GetUsersController::class)->middleware('auth2');
