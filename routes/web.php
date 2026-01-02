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

use App\Http\Controllers\LoginController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/lupa-password', function () {
    return view('login.lupa');
})->name('lupa-password');

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ObatController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Obat Resource Routes
    Route::resource('obat', ObatController::class);


    Route::get('/kasir', [App\Http\Controllers\KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/checkout', [App\Http\Controllers\KasirController::class, 'store'])->name('kasir.store');



    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/pengaturan', function () {
        return view('backend.pengaturan.index');
    })->name('pengaturan.index');
});