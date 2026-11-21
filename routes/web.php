<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicBlogController;
use Illuminate\Support\Facades\Route;

// ======================================================
// PÁGINA PRINCIPAL
// ======================================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/publicaciones', [PublicBlogController::class, 'index'])
    ->name('blog.index');

Route::get('/publicaciones/{slug}', [PublicBlogController::class, 'show'])
    ->name('blog.show');

// ======================================================
// PANEL ADMINISTRATIVO
// Solo pueden ingresar usuarios autenticados.
// ======================================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'can:access-admin-panel'])
    ->name('dashboard');

Route::middleware(['auth', 'can:access-admin-panel'])
    ->prefix('/admin/categorias')
    ->name('categories.')
    ->controller(CategoryController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}/edit', 'edit')->name('edit');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('destroy');
    });

Route::middleware(['auth', 'can:access-admin-panel'])
    ->prefix('/admin/publicaciones')
    ->name('publications.')
    ->controller(PublicationController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{publication}/edit', 'edit')->name('edit');
        Route::put('/{publication}', 'update')->name('update');
        Route::delete('/{publication}', 'destroy')->name('destroy');
    });

Route::middleware(['auth', 'can:access-admin-panel'])
    ->prefix('/admin/evidencias')
    ->name('evidences.')
    ->controller(EvidenceController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{evidence}/edit', 'edit')->name('edit');
        Route::put('/{evidence}', 'update')->name('update');
        Route::delete('/{evidence}', 'destroy')->name('destroy');
        Route::get('/{evidence}/preview', 'preview')->name('preview');
        Route::get('/{evidence}/download', 'download')->name('download');
        Route::get('/{evidence}/attachments/{attachment}/preview', 'attachmentPreview')->name('attachments.preview');
        Route::get('/{evidence}/attachments/{attachment}/download', 'attachmentDownload')->name('attachments.download');
    });

// ======================================================
// RUTAS DE AUTENTICACIÓN
// ======================================================

require __DIR__.'/auth.php';
