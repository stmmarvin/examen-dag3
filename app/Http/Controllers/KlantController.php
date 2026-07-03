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
        if (! Schema::hasTable('klant')) {
            return $this->indexFromLaravelTable($request);
        }

        $postcode = trim((string) $request->query('postcode', ''));

        $query = Klant::query()
            ->with(['contacten', 'user'])
            ->where('IsActief', true)
            ->when($postcode !== '', function ($query) use ($postcode): void {
                $query->whereHas('contacten', function ($contactQuery) use ($postcode): void {
                    $contactQuery->where('Postcode', $postcode);
                });
            })
            ->orderBy('Achternaam')
            ->orderBy('Voornaam');

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
                Rule::unique('Contact', 'Email')->ignore($contact->Id, 'Id'),
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
            DB::transaction(function () use ($request, $klant, $contact): void {
                $naam = $this->splitNaam((string) $request->input('naam'));

                $klant->update([
                    'Voornaam' => $naam['voornaam'],
                    'Tussenvoegsel' => $naam['tussenvoegsel'],
                    'Achternaam' => $naam['achternaam'],
                    'Bijzonderheden' => $request->input('bijzonderheden'),
                    'DatumGewijzigd' => now(),
                ]);

                $contact->update([
                    'Straatnaam' => $request->input('straatnaam'),
                    'Huisnummer' => $request->input('huisnummer'),
                    'Toevoeging' => $request->input('toevoeging'),
                    'Postcode' => $request->input('postcode'),
                    'Plaats' => $request->input('plaats'),
                    'Email' => $request->input('contact_email'),
                    'Mobiel' => $request->input('mobiel'),
                    'DatumGewijzigd' => now(),
                ]);
            });
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
            ->with('updated_klant_id', $klant->Id);
    }

    private function findKlant(int $id): Klant
    {
        return Klant::with(['contacten', 'user'])->findOrFail($id);
    }

    private function indexFromLaravelTable(Request $request): View
    {
        $postcode = trim((string) $request->query('postcode', ''));

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
        return $klant->contacten->firstWhere('IsActief', true)
            ?? $klant->contacten->first()
            ?? abort(404);
    }

    /**
     * Split the single wireframe name field back into the Klant table fields.
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
