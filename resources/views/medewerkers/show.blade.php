<x-app-layout>
    <div class="flex min-h-[calc(100vh-4rem)] flex-col bg-slate-100 py-10">
        <div class="mx-auto w-full max-w-[1700px] flex-1 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 max-w-[1580px] rounded-md border border-green-200 bg-green-100 px-4 py-4 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-6 text-sm">
                <a href="{{ route('dashboard') }}" class="font-semibold text-red-600 hover:text-red-700">Home</a>
                <span class="mx-2 text-slate-400">/</span>
                <a href="{{ route('medewerkers.index') }}" class="font-semibold text-red-600 hover:text-red-700">Medewerkers</a>
                <span class="mx-2 text-slate-400">/</span>
                <span class="font-semibold text-slate-500">Detail</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold text-red-700">
                Medewerkerdetail <span class="text-slate-500">{{ $medewerker->volledige_naam }}</span>
            </h1>

            <section class="max-w-3xl rounded-lg bg-white p-4 shadow-lg">
                <table class="w-full border-collapse text-left text-sm">
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        <tr>
                            <th class="w-1/4 px-3 py-2 font-bold text-slate-900">Naam</th>
                            <td class="px-3 py-2">{{ $medewerker->volledige_naam }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Specialisatie</th>
                            <td class="px-3 py-2">{{ $medewerker->Specialisatie ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Geboortedatum</th>
                            <td class="px-3 py-2">{{ $medewerker->Geboortedatum?->format('d-m-Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Contact e-mail</th>
                            <td class="px-3 py-2">{{ $contact?->Email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Account e-mail</th>
                            <td class="px-3 py-2">{{ $medewerker->user?->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Straatnaam</th>
                            <td class="px-3 py-2">{{ $contact?->Straatnaam ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Huisnummer</th>
                            <td class="px-3 py-2">{{ $contact?->Huisnummer ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Toevoeging</th>
                            <td class="px-3 py-2">{{ $contact?->Toevoeging ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Postcode</th>
                            <td class="px-3 py-2">{{ $contact?->Postcode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Plaats</th>
                            <td class="px-3 py-2">{{ $contact?->Plaats ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Mobiel</th>
                            <td class="px-3 py-2">{{ $contact?->Mobiel ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-3 py-2 font-bold text-slate-900">Opmerking</th>
                            <td class="px-3 py-2">{{ $medewerker->Opmerking ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-5 flex justify-end gap-3">
                    <a href="{{ route('medewerkers.edit', $medewerker) }}" class="rounded-md bg-red-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-red-800">
                        Wijzigen
                    </a>
                    <a href="{{ route('medewerkers.index') }}" class="rounded-md border border-blue-500 px-4 py-2 text-sm font-bold text-blue-600 transition hover:bg-blue-500 hover:text-white">
                        Terug
                    </a>
                </div>
            </section>
        </div>

        <p class="mt-auto px-4 pt-10 text-center text-sm text-slate-400">&copy; 2026 Kniploket Tiko - Alle rechten voorbehouden</p>
    </div>
</x-app-layout>
