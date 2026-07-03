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

    // Haalt medewerkers op, eventueel gefilterd op de gekozen specialisatie.
    $medewerkers = Medewerker::query()
        ->with('contacten')
        ->when($specialisatie, function ($query) use ($specialisatie) {
            $query->where('Specialisatie', $specialisatie);
        })
        ->orderBy('Voornaam')
        ->orderBy('Achternaam')
        ->paginate(4)
        ->withQueryString();

    // Deze opties staan vast, zodat Permanent ook altijd zichtbaar is.
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
    // Laadt de contactgegevens en het account bij deze medewerker.
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
    // Controleert alle velden voordat er iets wordt opgeslagen.
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

    // Slaat medewerker en contact samen op. Als iets fout gaat, wordt alles teruggedraaid.
    DB::transaction(function () use ($data, $medewerker) {
        // Splitst de volledige naam naar voornaam, tussenvoegsel en achternaam.
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

        // Gebruikt het bestaande contact, of maakt er een aan als die nog mist.
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
        // Zorgt dat dit contact gekoppeld blijft aan de medewerker.
        $medewerker->contacten()->syncWithoutDetaching([$contact->Id]);
    });

    return redirect()
        ->route('medewerkers.show', $medewerker)
        ->with('status', 'Medewerkergegevens bijgewerkt.');
})->middleware(['auth', 'verified'])->name('medewerkers.update');

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

    // Producten routes
    Route::get('/producten', [App\Http\Controllers\ProductController::class, 'index'])->name('producten.index');
    Route::get('/producten/nieuw', [App\Http\Controllers\ProductController::class, 'create'])->name('producten.create');
    Route::post('/producten', [App\Http\Controllers\ProductController::class, 'store'])->name('producten.store');
    Route::get('/producten/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('producten.show');
    Route::get('/producten/{product}/wijzigen', [App\Http\Controllers\ProductController::class, 'edit'])->name('producten.edit');
    Route::put('/producten/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('producten.update');
    Route::delete('/producten/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('producten.destroy');
});

require __DIR__.'/auth.php';
