<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KlantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/klanten', [KlantController::class, 'index'])->name('klanten.index');
    Route::get('/klanten/details', [KlantController::class, 'details'])->name('klanten.details');
    Route::get('/klanten/details/wijzigen', [KlantController::class, 'detailsEdit'])->name('klanten.details.edit');
    Route::get('/klanten/5', fn () => redirect('/klanten/details'));
    Route::get('/klanten/5/wijzigen', fn () => redirect('/klanten/details/wijzigen'));
    Route::get('/klanten/{id}', [KlantController::class, 'show'])->name('klanten.show');
    Route::get('/klanten/{id}/wijzigen', [KlantController::class, 'edit'])->name('klanten.edit');
    Route::patch('/klanten/{id}', [KlantController::class, 'update'])->name('klanten.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
