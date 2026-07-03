<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Breadcrumb navigatie --}}
            <nav class="text-sm mb-6 text-gray-600">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-800">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('behandelingen.index') }}" class="hover:text-gray-800">Behandelingen</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800">Detail</span>
            </nav>

            <div class="bg-white rounded-lg shadow p-8">
                {{-- Pagina titels --}}
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Producten per behandeling</h1>
                <h2 class="text-xl text-gray-500 mb-8">{{ $behandeling->naam }}</h2>

                {{-- Producten tabel --}}
                <div class="overflow-x-auto border border-gray-200 rounded">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-red-600 text-white">
                                <th class="px-4 py-3 text-left font-semibold text-sm">Product</th>
                                <th class="px-4 py-3 text-left font-semibold text-sm">Merk</th>
                                <th class="px-4 py-3 text-left font-semibold text-sm">Omschrijving</th>
                                <th class="px-4 py-3 text-left font-semibold text-sm">EAN-code</th>
                                <th class="px-4 py-3 text-left font-semibold text-sm">Aantal op voorraad</th>
                                <th class="px-4 py-3 text-left font-semibold text-sm">Verkoopprijs</th>
                                <th class="px-4 py-3 text-left font-semibold text-sm">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($producten as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">{{ $product->naam }}</td>
                                    <td class="px-4 py-3 text-sm">Tiko Care</td>
                                    <td class="px-4 py-3 text-sm">{{ $product->beschrijving }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $product->sku }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $product->voorraad }}</td>
                                    <td class="px-4 py-3 text-sm">EUR {{ number_format($product->prijs, 2) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('behandelingen.product.detail', [$behandeling->id, $product->id]) }}" 
                                           class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded text-sm inline-block">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                        Geen producten gevonden voor deze behandeling
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Terug knop --}}
                <div class="mt-6">
                    <a href="{{ route('behandelingen.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium inline-block">
                        Terug
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
