<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login.login');
})->name('login');

Route::get('/lupa-password', function () {
    return view('login.lupa');
})->name('lupa-password');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index');

Route::get('/kasir', function () {
    return view('kasir.index');
})->name('kasir.index');

Route::get('/obat', function () {
    return view('obat.index');
})->name('obat.index');

Route::get('/laporan', function () {
    return view('laporan.index');
})->name('laporan.index');

Route::get('/pengaturan', function () {
    return view('pengaturan.index');
})->name('pengaturan.index');

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');