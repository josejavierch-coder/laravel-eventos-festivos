<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\EventoFestivoController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Rutas Públicas
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/evento/{slug}', [PublicController::class, 'show'])->name('eventos.show.public');

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Recuperación de Contraseña
Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');

// Rutas de Administración Protegidas
Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('admin.dashboard');

    Route::get('/perfil', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('admin.perfil');
    Route::put('/perfil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('admin.perfil.update');
    Route::put('/perfil/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('admin.perfil.password');

    Route::get('/categorias/reporte-pdf', [CategoriaController::class, 'reportPdf'])->name('categorias.pdf');
    Route::patch('/categorias/{categoria}/toggle-status', [CategoriaController::class, 'toggleStatus'])->name('categorias.toggle-status');
    Route::resource('categorias', CategoriaController::class);

    Route::get('/salones/reporte-pdf', [SalonController::class, 'reportPdf'])->name('salones.pdf');
    Route::patch('/salones/{salon}/toggle-status', [SalonController::class, 'toggleStatus'])->name('salones.toggle-status');
    Route::resource('salones', SalonController::class);
    
    Route::get('/eventos/reporte-pdf', [EventoFestivoController::class, 'reportPdf'])->name('admin.eventos.pdf');
    Route::patch('/eventos/{evento}/toggle-status', [EventoFestivoController::class, 'toggleStatus'])->name('admin.eventos.toggle-status');
    Route::delete('/eventos/foto/{foto}', [EventoFestivoController::class, 'deletePhoto'])->name('admin.eventos.delete-photo');
    Route::resource('eventos', EventoFestivoController::class)->names('admin.eventos');
    Route::resource('usuarios', \App\Http\Controllers\UserController::class);
});
