<?php

use App\Http\Controllers\ProfileController;
use App\Models\Medewerker;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/medewerkers', function () {
    $specialisatie = request('specialisatie');

    $medewerkers = Medewerker::query()
        ->with('contacten')
        ->when($specialisatie, function ($query) use ($specialisatie) {
            $query->where('Specialisatie', $specialisatie);
        })
        ->orderBy('Voornaam')
        ->orderBy('Achternaam')
        ->paginate(10)
        ->withQueryString();

    $specialisaties = Medewerker::query()
        ->whereNotNull('Specialisatie')
        ->where('Specialisatie', '!=', '')
        ->distinct()
        ->orderBy('Specialisatie')
        ->pluck('Specialisatie');

    return view('medewerkers.index', [
        'medewerkers' => $medewerkers,
        'specialisaties' => $specialisaties,
        'geselecteerdeSpecialisatie' => $specialisatie,
    ]);
})->middleware(['auth', 'verified'])->name('medewerkers.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
