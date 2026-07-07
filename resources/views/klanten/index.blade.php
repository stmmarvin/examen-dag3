<x-app-layout>
    <div class="min-h-screen bg-gray-100 pb-12">
        <div class="max-w-6xl mx-auto px-6 pt-10">
            @if (session('success'))
                <div id="klant-flash" class="mb-6 rounded-md border border-green-200 bg-green-100 px-4 py-4 text-sm text-green-900">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-5 text-sm font-semibold">
                <a href="{{ route('dashboard') }}" class="text-red-600">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-500">Klanten</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold text-red-600">Overzicht klanten</h1>

            <div class="mb-4 rounded-xl bg-white p-4 shadow-sm">
                <form method="GET" action="{{ route('klanten.index') }}" class="flex items-end justify-end gap-3">
                    <div class="w-72">
                        <label for="postcode" class="mb-1 block text-sm font-semibold text-gray-700">Postcode zoeken</label>
                        <input
                            id="postcode"
                            name="postcode"
                            type="text"
                            value="{{ $postcode }}"
                            placeholder="Bijv. 3512AB"
                            class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                    </div>
                    <button type="submit" class="rounded-md bg-red-600 px-5 py-2 text-sm font-bold text-white hover:bg-red-700">
                        Toon Klanten
                    </button>
                    <a href="{{ route('klanten.index') }}" class="rounded-md bg-gray-500 px-5 py-2 text-sm font-bold text-white hover:bg-gray-600">
                        Reset
                    </a>
                </form>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 py-3 text-sm text-gray-500">
                    <span>Gevonden klanten - {{ $aantalKlanten }} klant(en)</span>

                    @if ($klanten->hasPages())
                        <div class="flex items-center gap-2">
                            @if ($klanten->onFirstPage())
                                <span class="rounded border border-gray-200 px-3 py-2 text-gray-300">&lsaquo;</span>
                            @else
                                <a href="{{ $klanten->previousPageUrl() }}" class="rounded border border-gray-200 px-3 py-2 text-gray-500">&lsaquo;</a>
                            @endif

                            @for ($page = 1; $page <= $klanten->lastPage(); $page++)
                                <a
                                    href="{{ $klanten->url($page) }}"
                                    class="rounded px-3 py-2 text-sm font-bold {{ $klanten->currentPage() === $page ? 'bg-red-600 text-white' : 'border border-gray-200 text-red-600' }}"
                                >
                                    {{ $page }}
                                </a>
                            @endfor

                            @if ($klanten->hasMorePages())
                                <a href="{{ $klanten->nextPageUrl() }}" class="rounded border border-gray-200 px-3 py-2 text-gray-500">&rsaquo;</a>
                            @else
                                <span class="rounded border border-gray-200 px-3 py-2 text-gray-300">&rsaquo;</span>
                            @endif
                        </div>
                    @endif
                </div>

                <table class="w-full border-collapse text-left text-sm">
                    <thead>
                        <tr class="bg-red-600 text-white">
                            <th class="px-4 py-3 font-bold">Naam</th>
                            <th class="px-4 py-3 font-bold">Relatienummer</th>
                            <th class="px-4 py-3 font-bold">Adres</th>
                            <th class="px-4 py-3 font-bold">Postcode</th>
                            <th class="px-4 py-3 font-bold">Woonplaats</th>
                            <th class="px-4 py-3 font-bold">Mobiel</th>
                            <th class="px-4 py-3 font-bold">Contact e-mail</th>
                            <th class="px-4 py-3 text-center font-bold">Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($klanten as $klant)
                            @php
                                $contact = $klant->contact ?? ($klant->contacten->firstWhere('is_actief', true) ?? $klant->contacten->first());
                                $adres = trim(($contact?->straatnaam ?? '') . ' ' . ($contact?->huisnummer ?? '') . ' ' . ($contact?->toevoeging ?? ''));
                            @endphp
                            <tr class="border-b border-gray-200 {{ session('updated_klant_id') === $klant->id ? 'bg-gray-200' : '' }}">
                                <td class="px-4 py-3 text-gray-700">{{ $klant->volledige_naam }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $klant->relatienummer }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $adres }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $contact?->postcode }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $contact?->plaats }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $contact?->mobiel }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $contact?->email }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ $klant->id == 5 ? route('klanten.details') : route('klanten.show', $klant->id) }}" class="inline-block rounded-md border border-blue-500 px-4 py-1 text-sm font-semibold text-blue-600 hover:bg-blue-500 hover:text-white">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-700">
                                    Er zijn geen klanten bekend die de geselecteerde postcode hebben
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-16 text-center text-sm text-gray-400">
                &copy; 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            setTimeout(function () {
                const melding = document.getElementById('klant-flash');
                if (melding) {
                    melding.remove();
                }
            }, 3000);
        </script>
    @endif
</x-app-layout>
