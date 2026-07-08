<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Klant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KlantController extends Controller
{
    public function index(Request $request): View
    {
        // Gebruikt de eenvoudige klanttabel als de examen-databasetabellen nog niet bestaan.
        if (! Schema::hasTable('klant')) {
            return $this->indexFromLaravelTable($request);
        }

        $postcode = trim((string) $request->query('postcode', ''));

        // Haalt actieve klanten op en filtert optioneel op postcode via de gekoppelde contactgegevens.
        $query = Klant::query()
            ->with(['contacten', 'user'])
            ->where('is_actief', true)
            ->when($postcode !== '', function ($query) use ($postcode): void {
                $query->whereHas('contacten', function ($contactQuery) use ($postcode): void {
                    $contactQuery->where('postcode', $postcode);
                });
            })
            ->orderBy('achternaam')
            ->orderBy('voornaam');

        $aantalKlanten = (clone $query)->count();
        $klanten = $query->paginate(4)->withQueryString();

        return view('klanten.index', [
            'klanten' => $klanten,
            'aantalKlanten' => $aantalKlanten,
            'postcode' => $postcode,
        ]);
    }

    public function show(int $id): View
    {
        // Toont de klantdetailpagina met het actieve contact van de klant.
        if (! Schema::hasTable('klant')) {
            $klant = $this->findLaravelKlant($id);

            return view('klanten.show', [
                'klant' => $klant,
                'contact' => $klant->contact,
            ]);
        }

        $klant = $this->findKlant($id);

        return view('klanten.show', [
            'klant' => $klant,
            'contact' => $this->getContact($klant),
        ]);
    }

    public function details(): View
    {
        return $this->show(5);
    }

    public function detailsEdit(): View
    {
        return $this->edit(5);
    }

    public function edit(int $id): View
    {
        // Laadt de bestaande klantgegevens voor het wijzigformulier.
        if (! Schema::hasTable('klant')) {
            $klant = $this->findLaravelKlant($id);

            return view('klanten.edit', [
                'klant' => $klant,
                'contact' => $klant->contact,
            ]);
        }

        $klant = $this->findKlant($id);

        return view('klanten.edit', [
            'klant' => $klant,
            'contact' => $this->getContact($klant),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        // Werkt klant- en contactgegevens bij en bewaart alles in een transactie.
        if (! Schema::hasTable('klant')) {
            return $this->updateLaravelKlant($request, $id);
        }

        $klant = $this->findKlant($id);
        $contact = $this->getContact($klant);

        $validator = Validator::make($request->all(), [
            'naam' => ['required', 'string', 'max:255'],
            'contact_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('contact', 'email')->ignore($contact->id, 'id'),
            ],
            'straatnaam' => ['required', 'string', 'max:255'],
            'huisnummer' => ['required', 'string', 'max:10'],
            'toevoeging' => ['nullable', 'string', 'max:10'],
            'postcode' => ['required', 'string', 'max:10'],
            'plaats' => ['required', 'string', 'max:100'],
            'mobiel' => ['required', 'string', 'max:20'],
            'bijzonderheden' => ['nullable', 'string'],
        ], [
            'contact_email.unique' => 'Het e-mailadres is al in gebruik',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Klantgegevens zijn niet bijgewerkt');
        }

        try {
            // Slaat klant en contact samen op, zodat bij een fout niets half wordt bijgewerkt.
            DB::transaction(function () use ($request, $klant, $contact): void {
                $naam = $this->splitNaam((string) $request->input('naam'));

                $klant->update([
                    'voornaam' => $naam['voornaam'],
                    'tussenvoegsel' => $naam['tussenvoegsel'],
                    'achternaam' => $naam['achternaam'],
                    'bijzonderheden' => $request->input('bijzonderheden'),
                    'datum_gewijzigd' => now(),
                ]);

                $contact->update([
                    'straatnaam' => $request->input('straatnaam'),
                    'huisnummer' => $request->input('huisnummer'),
                    'toevoeging' => $request->input('toevoeging'),
                    'postcode' => $request->input('postcode'),
                    'plaats' => $request->input('plaats'),
                    'email' => $request->input('contact_email'),
                    'mobiel' => $request->input('mobiel'),
                    'datum_gewijzigd' => now(),
                ]);
            });
        } catch (\Throwable $exception) {
            Log::error('Klantgegevens bijwerken mislukt.', [
                'klant_id' => $klant->id,
                'message' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Klantgegevens zijn niet bijgewerkt');
        }

        return redirect()
            ->route('klanten.index')
            ->with('success', 'Klantgegevens bijgewerkt')
            ->with('updated_klant_id', $klant->id);
    }

    private function findKlant(int $id): Klant
    {
        return Klant::with(['contacten', 'user'])->findOrFail($id);
    }

    private function indexFromLaravelTable(Request $request): View
    {
        $postcode = trim((string) $request->query('postcode', ''));

        // Fallback voor projecten waar klantgegevens in een platte Laravel-tabel staan.
        $query = DB::table('klant')
            ->when($postcode !== '', function ($query) use ($postcode): void {
                $query->where('postcode', $postcode);
            })
            ->orderBy('achternaam')
            ->orderBy('voornaam');

        $aantalKlanten = (clone $query)->count();
        $klanten = $query->paginate(4)->withQueryString();
        $klanten->setCollection($klanten->getCollection()->map(fn ($klant) => $this->normalizeLaravelKlant($klant)));

        return view('klanten.index', [
            'klanten' => $klanten,
            'aantalKlanten' => $aantalKlanten,
            'postcode' => $postcode,
        ]);
    }

    private function findLaravelKlant(int $id): object
    {
        $klant = DB::table('klant')->where('id', $id)->first();

        abort_if(! $klant, 404);

        return $this->normalizeLaravelKlant($klant);
    }

    private function updateLaravelKlant(Request $request, int $id): RedirectResponse
    {
        $klant = $this->findLaravelKlant($id);

        $validator = Validator::make($request->all(), [
            'naam' => ['required', 'string', 'max:255'],
            'contact_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('klant', 'email')->ignore($id),
            ],
            'straatnaam' => ['required', 'string', 'max:255'],
            'huisnummer' => ['required', 'string', 'max:10'],
            'toevoeging' => ['nullable', 'string', 'max:10'],
            'postcode' => ['required', 'string', 'max:10'],
            'plaats' => ['required', 'string', 'max:100'],
            'mobiel' => ['required', 'string', 'max:20'],
            'bijzonderheden' => ['nullable', 'string'],
        ], [
            'contact_email.unique' => 'Het e-mailadres is al in gebruik',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Klantgegevens zijn niet bijgewerkt');
        }

        try {
            $naam = $this->splitNaam((string) $request->input('naam'));
            $adres = trim($request->input('straatnaam') . ' ' . $request->input('huisnummer') . ' ' . $request->input('toevoeging'));

            DB::table('klant')
                ->where('id', $id)
                ->update([
                    'voornaam' => $naam['voornaam'],
                    'achternaam' => trim(($naam['tussenvoegsel'] ? $naam['tussenvoegsel'] . ' ' : '') . $naam['achternaam']),
                    'email' => $request->input('contact_email'),
                    'telefoon' => $request->input('mobiel'),
                    'postcode' => $request->input('postcode'),
                    'adres' => $adres,
                    'notities' => $request->input('bijzonderheden'),
                    'updated_at' => now(),
                ]);
        } catch (\Throwable $exception) {
            Log::error('Klantgegevens bijwerken mislukt.', [
                'klant_id' => $klant->Id,
                'message' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Klantgegevens zijn niet bijgewerkt');
        }

        return redirect()
            ->route('klanten.index')
            ->with('success', 'Klantgegevens bijgewerkt')
            ->with('updated_klant_id', $id);
    }

    private function normalizeLaravelKlant(object $klant): object
    {
        // Zet de platte klanttabel om naar dezelfde vorm als het normale klantmodel.
        $adresDelen = preg_split('/\s+/', trim((string) ($klant->adres ?? ''))) ?: [];
        $huisnummer = '';

        if ($adresDelen !== [] && preg_match('/^\d+[a-zA-Z]?$/', end($adresDelen))) {
            $huisnummer = array_pop($adresDelen);
        }

        $straatnaam = implode(' ', $adresDelen);
        $volledigeNaam = trim(($klant->voornaam ?? '') . ' ' . ($klant->achternaam ?? ''));

        $contact = (object) [
            'Id' => $klant->id,
            'Straatnaam' => $straatnaam,
            'Huisnummer' => $huisnummer,
            'Toevoeging' => '',
            'Postcode' => $klant->postcode ?? '',
            'Plaats' => '',
            'Email' => $klant->email ?? '',
            'Mobiel' => $klant->telefoon ?? '',
        ];

        return (object) [
            'Id' => $klant->id,
            'Relatienummer' => 'KL-' . str_pad((string) $klant->id, 3, '0', STR_PAD_LEFT),
            'Bijzonderheden' => $klant->notities ?? '',
            'volledige_naam' => $volledigeNaam,
            'contact' => $contact,
            'user' => (object) ['email' => $klant->email ?? ''],
        ];
    }

    private function getContact(Klant $klant): Contact
    {
        // Gebruikt eerst het actieve contact en valt anders terug op het eerste gekoppelde contact.
        return $klant->contacten->firstWhere('is_actief', true)
            ?? $klant->contacten->first()
            ?? abort(404);
    }

    /**
     * Splitst het enkele naamveld uit het formulier terug naar klantkolommen.
     */
    private function splitNaam(string $naam): array
    {
        $delen = preg_split('/\s+/', trim($naam)) ?: [];

        if (count($delen) === 1) {
            return [
                'voornaam' => $delen[0],
                'tussenvoegsel' => null,
                'achternaam' => $delen[0],
            ];
        }

        return [
            'voornaam' => array_shift($delen),
            'achternaam' => array_pop($delen),
            'tussenvoegsel' => $delen === [] ? null : implode(' ', $delen),
        ];
    }
}
