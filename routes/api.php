<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);
Route::get('/users', [RegisterController::class, 'getAllUsers']);
