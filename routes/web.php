<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwhearController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::resource('hardwhear', SoftwareController::class);