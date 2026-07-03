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

    // Behandelingen routes - User Stories 5 & 6
    // Overzicht van alle behandelingen met filter optie
    Route::get('/behandelingen', [App\Http\Controllers\BehandelingController::class, 'index'])->name('behandelingen.index');
    
    // Toon producten voor specifieke behandeling
    Route::get('/behandelingen/{id}/producten', [App\Http\Controllers\BehandelingController::class, 'producten'])->name('behandelingen.producten');
    
    // Toon productdetails
    Route::get('/behandelingen/{behandelingId}/producten/{productId}', [App\Http\Controllers\BehandelingController::class, 'productDetail'])->name('behandelingen.product.detail');
    
    // Toon product wijzig formulier
    Route::get('/behandelingen/{behandelingId}/producten/{productId}/edit', [App\Http\Controllers\BehandelingController::class, 'editProduct'])->name('behandelingen.product.edit');
    
    // Werk productprijs bij (minimaal 30% marge)
    Route::put('/behandelingen/{behandelingId}/producten/{productId}', [App\Http\Controllers\BehandelingController::class, 'updateProduct'])->name('behandelingen.product.update');
});

require __DIR__.'/auth.php';
