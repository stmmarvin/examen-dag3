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
                            name="categorie" 
                            id="categorie" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                            <option value="">Alle categorieën</option>
                            @foreach(\App\Models\Categorie::orderBy('naam')->get() as $cat)
                                <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button 
                        type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition"
                    >
                        Maak selectie
                    </button>
                    <a 
                        href="{{ route('producten.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition"
                    >
                        Reset
                    </a>
                </form>
            </div>

            <!-- Product Count and Pagination Info -->
            <div class="mb-4 text-gray-600">
                <span class="font-medium">Gevonden producten:</span> {{ $producten->total() }} product(en)
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
                                    {{ $product->categorie->naam ?? '-' }}
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
                                    {{ $product->voorraad->aantal_op_voorraad ?? '-' }}
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

            <!-- Pagination -->
            @if($producten->hasPages())
                <div class="mt-6 flex justify-center">
                    <nav class="flex items-center gap-2">
                        {{-- Previous Page Link --}}
                        @if ($producten->onFirstPage())
                            <span class="px-3 py-2 text-gray-400 cursor-not-allowed">«</span>
                        @else
                            <a href="{{ $producten->previousPageUrl() }}" class="px-3 py-2 text-gray-600 hover:text-red-600">«</a>
                        @endif

                        {{-- Page Numbers --}}
                        @for ($i = 1; $i <= $producten->lastPage(); $i++)
                            @if ($i == $producten->currentPage())
                                <span class="px-4 py-2 bg-red-600 text-white rounded-md font-medium">{{ $i }}</span>
                            @else
                                <a href="{{ $producten->url($i) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">{{ $i }}</a>
                            @endif
                        @endfor

                        {{-- Next Page Link --}}
                        @if ($producten->hasMorePages())
                            <a href="{{ $producten->nextPageUrl() }}" class="px-3 py-2 text-gray-600 hover:text-red-600">»</a>
                        @else
                            <span class="px-3 py-2 text-gray-400 cursor-not-allowed">»</span>
                        @endif
                    </nav>
                </div>
            @endif

            <!-- Footer -->
            <div class="text-center text-gray-400 text-sm mt-8">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>
