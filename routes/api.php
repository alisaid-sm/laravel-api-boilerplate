<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class)->middleware('auth2');
Route::post('login', LoginController::class);
