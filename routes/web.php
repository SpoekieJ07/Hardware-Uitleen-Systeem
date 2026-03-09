<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\UitleenController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\AdminloanController;
use App\Models\Uitleen;

Route::get('/', [HardwareController::class, 'index'])->name('root');

Route::get('admin/dashboard', function () {
    // show every loan (admin‑style overview)
    $loans = Uitleen::with('hardware')
        ->latest()
        ->get();   // Latest and get means that we will get all the loans, sorted by the most recent ones first. The with('hardware') part is eager loading, which means that it will also load the related hardware information for each loan in a single query, improving performance when we access the hardware details in the view.

    return view('admin/dashboard', compact('loans'));
})->middleware(['auth'])->name('admin/dashboard');

Route::get('/home', function () {
    return view('hardware');
})->middleware(['auth'])->name('home');

Route::resource('hardware', HardwareController::class); // This will create all the necessary routes for CRUD operations on hardware, including index, create, store, show, edit, update, and destroy.
Route::get('/', [HardwareController::class, 'index'])->name('root');
Route::get('/hardware/create', [HardwareController::class, 'create'])->name('hardware.create');
Route::post('/hardware', [HardwareController::class, 'store'])->name('hardware.store');


Route::get('/uitleen', [UitleenController::class, 'index'])->name('uitleen.index');
Route::get('/uitleen/create', [UitleenController::class, 'create'])->name('uitleen.create');
Route::post('/uitleen', [UitleenController::class, 'store'])->name('uitleen.store');
Route::get('/uitleen/history', [UitleenController::class, 'history'])->name('uitleen.history');
Route::delete('/uitleen/{uitleen}', [UitleenController::class, 'destroy'])->name('uitleen.destroy');

Route::middleware(['auth', 'can:manage-loans'])->group(function () { // Middleware to ensure only authenticated users with the 'manage-loans' (admin role) permission can access these routes
    Route::get('/admin/hardware', [HardwareController::class, 'adminIndex'])->name('admin.hardware.index');
    Route::get('/admin/pending', [AdminloanController::class, 'index'])->name('admin.pending');
    Route::post('/admin/pending/{loanRequest}/approve', [AdminloanController::class, 'approve'])->name('admin.pending.approve');
    Route::post('/admin/pending/{loanRequest}/reject', [AdminloanController::class, 'reject'])->name('admin.pending.reject');
    Route::get('/admin/dashboard', [AdminloanController::class, 'dashboard'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
