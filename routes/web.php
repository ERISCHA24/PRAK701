<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;

// NO AUTH
Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// AUTH REQUIRED
Route::middleware('cek.login')->group(function () {

    // Redirect root ke daftar buku
    Route::get('/', fn() => redirect()->route('buku.index'));

    // CRUD Buku 
    Route::resource('buku', BukuController::class)->except(['show']);

    // CRUD Member
    Route::resource('member', MemberController::class)->except(['show']);

    // CRUD Peminjaman 
    Route::resource('peminjaman', PeminjamanController::class)->except(['show']);

    // Aksi khusus: tandai peminjaman selesai (PATCH)
    Route::patch(
        'peminjaman/{peminjaman}/selesai',
        [PeminjamanController::class, 'selesaikan']
    )->name('peminjaman.selesai');
});