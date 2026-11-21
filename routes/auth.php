<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Acceso exclusivo para administración.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Procesar las credenciales.
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.authenticate');

// Cerrar sesión.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
