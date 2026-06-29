<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');

            Route::resource('dosen', DosenController::class)
                ->except(['show']);

            Route::resource('mahasiswa', MahasiswaController::class)
                ->except(['show']);

            Route::resource('matakuliah', MatakuliahController::class)
                ->except(['show']);

            Route::resource('jadwal', JadwalController::class)
                ->except(['show']);

            Route::get('/krs', [KrsController::class, 'adminIndex'])
                ->name('krs.index');

            Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])
                ->name('krs.destroy');
        });

    Route::middleware('role:mahasiswa')
        ->prefix('mahasiswa')
        ->name('mahasiswa.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])
                ->name('dashboard');

            Route::get('/jadwal', [JadwalController::class, 'mahasiswaIndex'])
                ->name('jadwal.index');

            Route::get('/krs', [KrsController::class, 'mahasiswaIndex'])
                ->name('krs.index');

            Route::post('/krs', [KrsController::class, 'store'])
                ->name('krs.store');

            Route::get('/krs/pdf', [KrsController::class, 'exportPdf'])
                ->name('krs.pdf');

            Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])
                ->name('krs.destroy');
        });
});