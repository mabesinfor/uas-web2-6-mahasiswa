<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::delete('/program-studi/bulk-destroy', [ProgramStudiController::class, 'bulkDestroy'])->name('program-studi.bulk-destroy');
    Route::delete('/mahasiswa/bulk-destroy', [MahasiswaController::class, 'bulkDestroy'])->name('mahasiswa.bulk-destroy');
    Route::delete('/mata-kuliah/bulk-destroy', [MataKuliahController::class, 'bulkDestroy'])->name('mata-kuliah.bulk-destroy');
    Route::delete('/nilai/bulk-destroy', [NilaiController::class, 'bulkDestroy'])->name('nilai.bulk-destroy');
    Route::resource('program-studi', ProgramStudiController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('mata-kuliah', MataKuliahController::class);
    Route::resource('nilai', NilaiController::class);
});

require __DIR__.'/auth.php';