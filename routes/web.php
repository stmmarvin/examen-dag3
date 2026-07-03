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
        ->paginate(4)
        ->withQueryString();

    $specialisaties = collect([
        'Extensions',
        'Kleuren',
        'Knippen',
        'Permanent',
        'Stylen',
    ]);

    return view('medewerkers.index', [
        'medewerkers' => $medewerkers,
        'specialisaties' => $specialisaties,
        'geselecteerdeSpecialisatie' => $specialisatie,
    ]);
})->middleware(['auth', 'verified'])->name('medewerkers.index');

Route::get('/medewerkers/{medewerker}', function (Medewerker $medewerker) {
    $medewerker->load(['contacten', 'user']);

    return view('medewerkers.show', [
        'medewerker' => $medewerker,
        'contact' => $medewerker->contacten->first(),
    ]);
})->middleware(['auth', 'verified'])->name('medewerkers.show');

Route::get('/medewerkers/{medewerker}/wijzigen', function (Medewerker $medewerker) {
    $medewerker->load(['contacten', 'user']);

    return view('medewerkers.edit', [
        'medewerker' => $medewerker,
        'contact' => $medewerker->contacten->first(),
        'specialisaties' => collect([
            'Extensions',
            'Kleuren',
            'Knippen',
            'Permanent',
            'Stylen',
        ]),
    ]);
})->middleware(['auth', 'verified'])->name('medewerkers.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
