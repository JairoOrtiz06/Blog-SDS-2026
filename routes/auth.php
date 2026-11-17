<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Mostrar y procesar el registro de cuentas.
Route::get('/register', [AuthController::class, 'showRegistration'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Mostrar el formulario de inicio de sesión.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Procesar las credenciales.
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.authenticate');

// Cerrar sesión.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
