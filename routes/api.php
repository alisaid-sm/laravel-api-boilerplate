<?php
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Routing\Route;

Route::post('register', RegisterController::class);
