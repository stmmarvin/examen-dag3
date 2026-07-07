<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700 font-medium">Home</a>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-600">Producten</span>
            </div>

            <!-- Header -->
            <h1 class="text-3xl font-bold text-red-600 mb-6">Overzicht producten</h1>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('producten.index') }}" class="flex items-end gap-4">
                    <div class="flex-1">
                        <label for="categorie" class="block text-sm font-medium text-gray-700 mb-2">
                            Categorie selecteren
                        </label>
                        <select 
                            name="categorie_id" 
                            id="categorie" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                            <option value="">Alle categorieën</option>
                            @foreach($categorieen as $categorie)
                                <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button 
                        type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-2 py-0.5 rounded text-xs transition whitespace-nowrap"
                    >
                        Maak selectie
                    </button>
                    <a 
                        href="{{ route('producten.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-2 px-0.5 rounded text-xs transition whitespace-nowrap inline-flex items-center justify-center"
                    >
                        Reset
                    </a>
                </form>
            </div>

            <!-- Product Count and Pagination Info -->
            <div class="relative flex {{ $producten->hasPages() ? 'min-h-20' : 'min-h-12' }} flex-col gap-3 mb-4">
                <div class="text-gray-600">
                    <span class="font-medium">Gevonden producten:</span> {{ $producten->total() }} product(en)
                </div>

                {{-- Paginatie nummers zoals bij medewerkers --}}
                @if ($producten->hasPages())
                    <div class="flex items-center justify-center gap-2">
                        @if ($producten->onFirstPage())
                            <span class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-200 text-sm font-semibold text-gray-300">&lsaquo;</span>
                        @else
                            <a href="{{ $producten->previousPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-200 text-sm font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-50">&lsaquo;</a>
                        @endif

                        @foreach ($producten->getUrlRange(1, $producten->lastPage()) as $pagina => $url)
                            @if ($pagina === $producten->currentPage())
                                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-red-600 text-sm font-bold text-white">{{ $pagina }}</span>
                            @else
                                <a href="{{ $url }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-200 text-sm font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-50">{{ $pagina }}</a>
                            @endif
                        @endforeach

                        @if ($producten->hasMorePages())
                            <a href="{{ $producten->nextPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-200 text-sm font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-50">&rsaquo;</a>
                        @else
                            <span class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-200 text-sm font-semibold text-gray-300">&rsaquo;</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-red-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                Categorie
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                Merk
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                EAN-code
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                Verkoopprijs
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                Voorraad
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider">
                                Actie
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($producten as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $product->naam }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($product->categorie_id)
                                        {{ \App\Models\Categorie::find($product->categorie_id)?->naam ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $product->merk ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $product->ean_code ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($product->verkoop_prijs)
                                        EUR {{ number_format($product->verkoop_prijs, 2, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $product->voorraad ? $product->voorraad->AantalOpVoorraad : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a 
                                        href="{{ route('producten.show', $product->id) }}" 
                                        class="inline-block border-2 border-blue-500 text-blue-500 px-4 py-1 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition"
                                    >
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 italic">
                                    Er zijn geen producten bekend binnen de geselecteerde categorie
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>



            <!-- Footer -->
            <div class="text-center text-gray-400 text-sm mt-8">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>
