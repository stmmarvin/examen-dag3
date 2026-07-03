<x-app-layout>
    <div class="flex min-h-[calc(100vh-4rem)] flex-col bg-slate-100 py-10">
        <div class="mx-auto w-full max-w-[1700px] flex-1 px-4 sm:px-6 lg:px-8">
            <div class="mb-6 text-sm">
                <a href="{{ route('dashboard') }}" class="font-semibold text-red-600 hover:text-red-700">Home</a>
                <span class="mx-2 text-slate-400">/</span>
                <span class="font-semibold text-slate-500">Medewerkers</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold text-red-700">Overzicht medewerkers</h1>

            <form method="GET" action="{{ route('medewerkers.index') }}" class="mb-4 rounded-lg bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 md:ml-auto md:max-w-xl md:flex-row md:items-end">
                    <label class="flex-1">
                        <span class="mb-1 block text-xs font-bold text-slate-700">Specialisatie</span>
                        <select name="specialisatie" class="w-full rounded-md border-slate-300 text-sm text-slate-600 shadow-sm focus:border-red-600 focus:ring-red-600">
                            <option value="">Alle specialisaties</option>
                            @foreach ($specialisaties as $specialisatie)
                                <option value="{{ $specialisatie }}" @selected($geselecteerdeSpecialisatie === $specialisatie)>
                                    {{ $specialisatie }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <button type="submit" class="rounded-md bg-red-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-red-800">
                        Toon medewerkers
                    </button>

                    <a href="{{ route('medewerkers.index') }}" class="rounded-md bg-slate-500 px-4 py-2 text-center text-sm font-bold text-white shadow-sm transition hover:bg-slate-600">
                        Reset
                    </a>
                </div>
            </form>

            <section class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="relative flex min-h-20 flex-col gap-3 px-4 py-3">
                    <p class="text-sm text-slate-500">Gevonden medewerkers - {{ $medewerkers->total() }} medewerker(s)</p>

                    @if ($medewerkers->hasPages())
                        <div class="flex items-center justify-center gap-2 md:absolute md:left-1/2 md:top-1/2 md:-translate-x-1/2 md:-translate-y-1/2">
                            @if ($medewerkers->onFirstPage())
                                <span class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 text-sm font-semibold text-slate-300">&lsaquo;</span>
                            @else
                                <a href="{{ $medewerkers->previousPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 text-sm font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-50">&lsaquo;</a>
                            @endif

                            @foreach ($medewerkers->getUrlRange(1, $medewerkers->lastPage()) as $pagina => $url)
                                @if ($pagina === $medewerkers->currentPage())
                                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-red-700 text-sm font-bold text-white">{{ $pagina }}</span>
                                @else
                                    <a href="{{ $url }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 text-sm font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-50">{{ $pagina }}</a>
                                @endif
                            @endforeach

                            @if ($medewerkers->hasMorePages())
                                <a href="{{ $medewerkers->nextPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 text-sm font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-50">&rsaquo;</a>
                            @else
                                <span class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 text-sm font-semibold text-slate-300">&rsaquo;</span>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($medewerkers->isEmpty())
                    <div class="border-t border-slate-200 px-4 py-8 text-center font-semibold text-slate-600">
                        Er zijn geen medewerkers bekend met de geselecteerde specialisatie
                    </div>
                @else
                    <div class="px-5 pb-3 pt-2">
                    <table class="w-full table-fixed border-collapse text-left text-sm">
                        <thead class="bg-red-700 text-white">
                            <tr>
                                <th class="w-[14%] px-3 py-3 font-bold">Naam</th>
                                <th class="w-[12%] px-3 py-3 font-bold">Specialisatie</th>
                                <th class="w-[20%] px-3 py-3 font-bold">Adres</th>
                                <th class="w-[8%] px-3 py-3 font-bold">Postcode</th>
                                <th class="w-[10%] px-3 py-3 font-bold">Woonplaats</th>
                                <th class="w-[11%] px-3 py-3 font-bold">Mobiel</th>
                                <th class="w-[19%] px-3 py-3 font-bold">Contact e-mail</th>
                                <th class="w-[6%] px-3 py-3 text-center font-bold">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            @foreach ($medewerkers as $medewerker)
                                @php
                                    $contact = $medewerker->contacten->first();
                                    $adres = collect([
                                        $contact?->Straatnaam,
                                        trim(($contact?->Huisnummer ?? '') . ($contact?->Toevoeging ? ' ' . $contact->Toevoeging : '')),
                                    ])->filter()->implode(' ');
                                @endphp

                                <tr>
                                    <td class="break-words px-3 py-3">{{ $medewerker->volledige_naam }}</td>
                                    <td class="break-words px-3 py-3">{{ $medewerker->Specialisatie ?? '-' }}</td>
                                    <td class="break-words px-3 py-3">{{ $adres ?: '-' }}</td>
                                    <td class="break-words px-3 py-3">{{ $contact?->Postcode ?? '-' }}</td>
                                    <td class="break-words px-3 py-3">{{ $contact?->Plaats ?? '-' }}</td>
                                    <td class="break-words px-3 py-3">{{ $contact?->Mobiel ?? '-' }}</td>
                                    <td class="break-words px-3 py-3">{{ $contact?->Email ?? '-' }}</td>
                                    <td class="px-3 py-3 text-center">
                                        <button type="button" class="rounded-md border border-blue-500 px-3 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-500 hover:text-white">Details</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                @endif
            </section>

        </div>

        <p class="mt-auto px-4 pt-10 text-center text-sm text-slate-400">&copy; 2026 Kniploket Tiko - Alle rechten voorbehouden</p>
    </div>
</x-app-layout>
