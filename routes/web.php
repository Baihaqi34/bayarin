<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TagihanController;

Route::get('/', function () {
    return view(view: 'welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');

    Route::get('pelanggan/cari/', [PelangganController::class, 'cari'])->name('pelanggan.cari');

    Route::post('pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');

    Route::put('pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');

    Route::delete('pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');


    Route::get('paket', [PaketController::class, 'index'])->name('paket.index');
    Route::post('paket', [PaketController::class, 'store'])->name('paket.store');
    Route::put('paket/{paket}', [PaketController::class, 'update'])->name('paket.update');
    Route::delete('paket/{paket}', [PaketController::class, 'destroy'])->name('paket.destroy');

    Route::get('tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::post('tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
    Route::put('tagihan/{tagihan}', [TagihanController::class, 'update'])->name('tagihan.update');
    Route::delete('tagihan/{tagihan}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');
    Route::post('tagihan/generate', [TagihanController::class, 'generateBulanan'])->name('tagihan.generate');
    Route::post('tagihan/{tagihan}/bayar', [TagihanController::class, 'pay'])->name('tagihan.pay');
    Route::get('tagihan/{tagihan}/print', [TagihanController::class, 'print'])->name('tagihan.print');
});
