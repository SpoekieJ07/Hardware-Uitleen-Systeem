<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\UitleenController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\AdminUitleenController;

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

Route::get('/uitleen/historie', [UitleenController::class, 'history'])->name('uitleen.history');

Route::get('/loan-requests/create', [LoanRequestController::class, 'create'])->name('loan_requests.create');
Route::post('/loan-requests', [LoanRequestController::class, 'store'])->name('loan_requests.store');
Route::get('/my-loan-requests', [LoanRequestController::class, 'my'])->name('loan_requests.my');




Route::get('/admin/uitleen/pending', [AdminUitleenController::class, 'pending'])
    ->name('admin.uitleen.pending');

Route::post('/admin/uitleen/{uitleen}/approve', [AdminUitleenController::class, 'approve'])
    ->name('admin.uitleen.approve');
