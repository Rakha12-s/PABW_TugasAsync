<?php

use Illuminate\Support\Facades\Route;
use Modules\Perpustakaan\Http\Controllers\PerpustakaanController;

Route::middleware(['auth'])->prefix('perpustakaan')->group(function () {
    Route::get('/buku', [PerpustakaanController::class, 'index'])->name('perpustakaan.index');
    Route::post('/buku', [PerpustakaanController::class, 'store'])->name('perpustakaan.store');
    Route::get('/buku/{id}/edit', [PerpustakaanController::class, 'edit'])->name('perpustakaan.edit');
    Route::put('/buku/{id}', [PerpustakaanController::class, 'update'])->name('perpustakaan.update');
    Route::delete('/buku/{id}', [PerpustakaanController::class, 'destroy'])->name('perpustakaan.destroy');
});