<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\UitleenController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\AdminLoanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

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


Route::middleware(['auth'])->group(function () {
    Route::get('/loan-requests/create', [LoanRequestController::class, 'create'])->name('loan_requests.create');
    Route::post('/loan-requests', [LoanRequestController::class, 'store'])->name('loan_requests.store');
    Route::get('/my-loan-requests', [LoanRequestController::class, 'my'])->name('loan_requests.my');
});

Route::middleware(['auth', 'can:manage-loans'])->group(function () {
    Route::get('/admin/loan-requests', [AdminLoanController::class, 'index'])->name('admin.loan_requests.index');
    Route::post('/admin/loan-requests/{loanRequest}/approve', [AdminLoanController::class, 'approve'])->name('admin.loan_requests.approve');
    Route::post('/admin/loan-requests/{loanRequest}/reject', [AdminLoanController::class, 'reject'])->name('admin.loan_requests.reject');
});