<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Breadcrumb navigatie --}}
            <nav class="text-sm mb-6 text-gray-600">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-800">Home</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800">Behandelingen</span>
            </nav>

            <div class="bg-white rounded-lg shadow p-8">
                <h1 class="text-3xl font-bold mb-8 text-gray-800">Overzicht behandelingen</h1>

                {{-- Filter sectie met dropdown en knoppen --}}
                <div class="bg-gray-50 p-6 rounded mb-6">
                    <form method="GET" action="{{ route('behandelingen.index') }}" class="flex items-end gap-4" aria-label="Behandeling filter formulier">
                        <div class="flex-1">
                            <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">
                                Behandeling selecteren
                            </label>
                            <select name="filter" id="filter" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500 focus:ring-red-500" aria-label="Selecteer behandeling categorie">
                                <option value="alle">Alle behandelingen</option>
                                @foreach($behandelingNames as $naam)
                                    <option value="{{ $naam }}" {{ request('filter') == $naam ? 'selected' : '' }}>
                                        {{ $naam }}
                                    </option>
                                @endforeach
                                <option value="overig" {{ request('filter') == 'overig' ? 'selected' : '' }}>Overig</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded text-sm transition duration-200" aria-label="Filter toepassen">
                            Maak selectie
                        </button>
                        <a href="{{ route('behandelingen.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1.5 rounded text-sm inline-block transition duration-200" aria-label="Filter resetten">
                            Reset
                        </a>
                    </form>
                </div>

                {{-- Melding als categorie niet gevonden --}}
                @if(request('filter') == 'overig' && $behandelingen->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded">
                        Er zijn geen behandelingen bekend met deze categorie
                    </div>
                @else
                    {{-- Resultaat informatie --}}
                    <p class="text-sm text-gray-600 mb-4">
                        Gevonden behandelingen - {{ $behandelingen->total() }} behandeling(en)
                    </p>

                    {{-- Paginatie boven tabel --}}
                    <div class="flex justify-center mb-4">
                        {{ $behandelingen->onEachSide(1)->links() }}
                    </div>

                    {{-- Behandelingen tabel --}}
                    <div class="overflow-x-auto border border-gray-200 rounded">
                        <table class="w-full">
                            <caption class="sr-only">Overzicht van behandelingen met filters en acties</caption>
                            <thead>
                                <tr class="bg-red-600 text-white">
                                    <th class="px-4 py-3 text-left font-semibold text-sm">Soort</th>
                                    <th class="px-4 py-3 text-left font-semibold text-sm">Omschrijving</th>
                                    <th class="px-4 py-3 text-left font-semibold text-sm">Duur</th>
                                    <th class="px-4 py-3 text-left font-semibold text-sm">Prijs</th>
                                    <th class="px-4 py-3 text-left font-semibold text-sm">Aantal producten</th>
                                    <th class="px-4 py-3 text-left font-semibold text-sm">Actie</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($behandelingen as $behandeling)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-3 text-sm">{{ $behandeling->Naam }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $behandeling->Omschrijving }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $behandeling->Duurminuten }} min</td>
                                        <td class="px-4 py-3 text-sm">EUR {{ number_format($behandeling->Prijs, 2) }}</td>
                                        <td class="px-4 py-3 text-sm">{{ DB::table('BehandelingPerVoorraad')->where('BehandelingId', $behandeling->Id)->count() }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('behandelingen.producten', $behandeling->Id) }}" 
                                               class="bg-white border-2 border-blue-500 text-blue-500 hover:bg-blue-50 focus:ring-2 focus:ring-blue-300 focus:outline-none px-6 py-2 rounded-full text-sm inline-block font-medium transition duration-200">
                                                Producten
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                            Geen behandelingen gevonden
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
