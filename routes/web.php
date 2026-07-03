<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Behandelingen routes
    Route::get('/behandelingen', [App\Http\Controllers\BehandelingController::class, 'index'])->name('behandelingen.index');
    Route::get('/behandelingen/{id}/producten', [App\Http\Controllers\BehandelingController::class, 'producten'])->name('behandelingen.producten');
    Route::get('/behandelingen/{behandelingId}/producten/{productId}', [App\Http\Controllers\BehandelingController::class, 'productDetail'])->name('behandelingen.product.detail');
    Route::get('/behandelingen/{behandelingId}/producten/{productId}/edit', [App\Http\Controllers\BehandelingController::class, 'editProduct'])->name('behandelingen.product.edit');
    Route::put('/behandelingen/{behandelingId}/producten/{productId}', [App\Http\Controllers\BehandelingController::class, 'updateProduct'])->name('behandelingen.product.update');
});

require __DIR__.'/auth.php';
