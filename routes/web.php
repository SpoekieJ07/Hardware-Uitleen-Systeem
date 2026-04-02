<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\UitleenController;
use App\Http\Controllers\AdminloanController;

Route::get('/', [HardwareController::class, 'index'])->name('root');
Route::get('/hardware', [HardwareController::class, 'index'])->name('hardware.index');
Route::get('/hardware/{hardware}', [HardwareController::class, 'show'])->name('hardware.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return redirect()->route('hardware.index');
    })->name('home');

    Route::get('/uitleen', [UitleenController::class, 'index'])->name('uitleen.index');
    Route::get('/uitleen/create', [UitleenController::class, 'create'])->name('uitleen.create');
    Route::post('/uitleen', [UitleenController::class, 'store'])->name('uitleen.store');
    Route::get('/uitleen/history', [UitleenController::class, 'history'])->name('uitleen.history');
    Route::delete('/uitleen/{uitleen}', [UitleenController::class, 'destroy'])->name('uitleen.destroy');
});

Route::middleware(['auth', 'can:manage-hardware'])->group(function () {
    Route::get('/hardware/create', [HardwareController::class, 'create'])->name('hardware.create');
    Route::post('/hardware', [HardwareController::class, 'store'])->name('hardware.store');
    Route::get('/hardware/{hardware}/edit', [HardwareController::class, 'edit'])->name('hardware.edit');
    Route::put('/hardware/{hardware}', [HardwareController::class, 'update'])->name('hardware.update');
    Route::delete('/hardware/{hardware}', [HardwareController::class, 'destroy'])->name('hardware.destroy');
});

Route::middleware(['auth', 'can:manage-loans'])->group(function () {
    Route::get('/admin/hardware', [HardwareController::class, 'adminIndex'])->name('admin.hardware.index');
    Route::get('/admin/pending', [AdminloanController::class, 'index'])->name('admin.pending');
    Route::post('/admin/pending/{loanRequest}/approve', [AdminloanController::class, 'approve'])->name('admin.pending.approve');
    Route::post('/admin/pending/{loanRequest}/reject', [AdminloanController::class, 'reject'])->name('admin.pending.reject');

    Route::get('/admin/dashboard', [AdminloanController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/overdue', [AdminloanController::class, 'overdue'])->name('admin.overdue');
    Route::get('/admin/calendar', [AdminloanController::class, 'calendar'])->name('admin.calendar');
    Route::get('/admin/report', [AdminloanController::class, 'report'])->name('admin.report');
    Route::get('/admin/export/history', [AdminloanController::class, 'exportHistoryCsv'])->name('admin.export.history');
});

require __DIR__ . '/auth.php';
