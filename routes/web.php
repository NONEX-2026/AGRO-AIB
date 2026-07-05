<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\TrazabilidadController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Pagina publica del QR (sin autenticacion)
Route::get('/trazabilidad/publica/{codigo}', [QrController::class, 'verPaginaPublica'])->name('qr.publica');

Route::middleware('auth')->group(function () {

    // Dashboard - TODOS los roles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Lotes - TODOS pueden ver y crear/editar
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index');
    Route::get('/lotes/crear', [LoteController::class, 'create'])->name('lotes.create');
    Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');
    Route::get('/lotes/{lote}/editar', [LoteController::class, 'edit'])->name('lotes.edit');
    Route::put('/lotes/{lote}', [LoteController::class, 'update'])->name('lotes.update');

    // Eliminar lotes - SOLO Administrador
    Route::delete('/lotes/{lote}', [LoteController::class, 'destroy'])->name('lotes.destroy')
        ->middleware('role:Administrador');

    // Trazabilidad - TODOS pueden ver
    Route::get('/trazabilidad', [TrazabilidadController::class, 'index'])->name('trazabilidad.index');
    Route::get('/trazabilidad/{codigo}', [TrazabilidadController::class, 'show'])->name('trazabilidad.show');

    // Avanzar etapa - SOLO Administrador y Supervisor
    Route::post('/trazabilidad/avanzar', [TrazabilidadController::class, 'avanzarEtapa'])
        ->name('trazabilidad.avanzar')
        ->middleware('role:Administrador,Supervisor');

    // QR - TODOS los roles
    Route::get('/qr', [QrController::class, 'index'])->name('qr.index');
    Route::get('/qr/generar/{lote}', [QrController::class, 'generate'])->name('qr.generate');
    Route::get('/qr/datos/{lote}', [QrController::class, 'getData']);


    // Reportes - Administrador, Supervisor Y Transporte
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index')
        ->middleware('role:Administrador,Supervisor,Transporte');
    Route::get('/reportes/pdf', [ReporteController::class, 'exportPdf'])->name('reportes.pdf')
        ->middleware('role:Administrador,Supervisor,Transporte');

    // Usuarios - SOLO Administrador
    Route::middleware('role:Administrador')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::put('/usuarios/{usuario}/estado', [UsuarioController::class, 'toggleEstado'])->name('usuarios.toggle');
    });
});
