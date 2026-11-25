<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // <-- Kita gunakan DB Facade

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Menghitung buku langsung ke tabel MySQL tanpa butuh Model
    $totalBuku = DB::table('buku')->count();
    
    return view('dashboard', compact('totalBuku'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';