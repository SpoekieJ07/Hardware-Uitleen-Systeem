<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\UitleenController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\AdminloanController;

Route::get('/', [HardwareController::class, 'index'])->name('root');

use App\Models\Uitleen;

Route::get('admin/dashboard', function () {
    // show every loan (admin‑style overview)
    $loans = Uitleen::with('hardware')
        ->latest()
        ->get();

    return view('admin/dashboard', compact('loans'));
})->middleware(['auth'])->name('admin/dashboard');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::resource('hardware', HardwareController::class);
Route::get('/hardware', [HardwareController::class, 'index'])->name('hardware.index');
Route::get('/hardware/create', [HardwareController::class, 'create'])->name('hardware.create');
Route::post('/hardware', [HardwareController::class, 'store'])->name('hardware.store');


Route::get('/uitleen', [UitleenController::class, 'index'])->name('uitleen.index');
Route::get('/uitleen/create', [UitleenController::class, 'create'])->name('uitleen.create');
Route::post('/uitleen', [UitleenController::class, 'store'])->name('uitleen.store');
Route::get('/uitleen/history', [UitleenController::class, 'history'])->name('uitleen.history');
Route::delete('/uitleen/{uitleen}', [UitleenController::class, 'destroy'])->name('uitleen.destroy');

Route::middleware(['auth', 'can:manage-loans'])->group(function () {
    Route::get('/admin/hardware', [HardwareController::class, 'adminIndex'])->name('admin.hardware.index');
    Route::get('/admin/pending', [AdminloanController::class, 'index'])->name('admin.pending');
    Route::post('/admin/pending/{loanRequest}/approve', [AdminloanController::class, 'approve'])->name('admin.pending.approve');
    Route::post('/admin/pending/{loanRequest}/reject', [AdminloanController::class, 'reject'])->name('admin.pending.reject');
    Route::get('/admin/dashboard', [AdminloanController::class, 'dashboard'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
