<?php

use App\Http\Controllers\ProfileController;
use App\Models\Contact;
use App\Models\Medewerker;
use App\Rules\GeenPermanentVoorMinderjarige;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::patch('/medewerkers/{medewerker}', function (Request $request, Medewerker $medewerker) {
    $validator = Validator::make($request->all(), [
        'naam' => ['required', 'string', 'max:255'],
        'specialisatie' => ['required', 'string', 'in:Extensions,Kleuren,Knippen,Permanent,Stylen', new GeenPermanentVoorMinderjarige($request->input('geboortedatum'))],
        'geboortedatum' => ['required', 'date'],
        'contact_email' => ['required', 'email', 'max:255'],
        'straatnaam' => ['required', 'string', 'max:255'],
        'huisnummer' => ['required', 'string', 'max:10'],
        'toevoeging' => ['nullable', 'string', 'max:10'],
        'postcode' => ['required', 'string', 'max:10'],
        'plaats' => ['required', 'string', 'max:100'],
        'mobiel' => ['required', 'string', 'max:20'],
        'opmerking' => ['nullable', 'string', 'max:255'],
    ]);

    $data = $validator->validate();

    DB::transaction(function () use ($data, $medewerker) {
        $naamdelen = preg_split('/\s+/', trim($data['naam']));
        $voornaam = array_shift($naamdelen) ?: $data['naam'];
        $achternaam = array_pop($naamdelen) ?: '';
        $tussenvoegsel = $naamdelen ? implode(' ', $naamdelen) : null;

        $medewerker->update([
            'Voornaam' => $voornaam,
            'Tussenvoegsel' => $tussenvoegsel,
            'Achternaam' => $achternaam,
            'Specialisatie' => $data['specialisatie'],
            'Geboortedatum' => $data['geboortedatum'],
            'Opmerking' => $data['opmerking'],
            'DatumGewijzigd' => now(),
        ]);

        $contact = $medewerker->contacten()->first() ?? new Contact([
            'DatumAangemaakt' => now(),
            'IsActief' => true,
        ]);

        $contact->fill([
            'Straatnaam' => $data['straatnaam'],
            'Huisnummer' => $data['huisnummer'],
            'Toevoeging' => $data['toevoeging'],
            'Postcode' => $data['postcode'],
            'Plaats' => $data['plaats'],
            'Email' => $data['contact_email'],
            'Mobiel' => $data['mobiel'],
            'DatumGewijzigd' => now(),
        ]);

        $contact->save();
        $medewerker->contacten()->syncWithoutDetaching([$contact->Id]);
    });

    return redirect()
        ->route('medewerkers.show', $medewerker)
        ->with('status', 'Medewerkergegevens bijgewerkt.');
})->middleware(['auth', 'verified'])->name('medewerkers.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
