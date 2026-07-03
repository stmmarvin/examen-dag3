<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700 font-medium">Home</a>
                <span class="text-gray-400 mx-2">/</span>
                <a href="{{ route('producten.index') }}" class="text-red-600 hover:text-red-700 font-medium">Producten</a>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-600">{{ $product->Naam }}</span>
            </div>

            <!-- Header -->
            <h1 class="text-3xl font-bold text-red-600 mb-6">Product details</h1>

            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Basis informatie -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Basis informatie</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Product naam:</span>
                                <p class="text-gray-900">{{ $product->Naam }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Categorie:</span>
                                <p class="text-gray-900">{{ $product->categorie->Naam ?? '-' }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Merk:</span>
                                <p class="text-gray-900">{{ $product->Merk ?? '-' }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">EAN-code:</span>
                                <p class="text-gray-900 font-mono">{{ $product->EANcode ?? '-' }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Omschrijving:</span>
                                <p class="text-gray-900">{{ $product->Omschrijving ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Prijs en voorraad -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Prijs & Voorraad</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Inkoopprijs:</span>
                                <p class="text-gray-900">
                                    @if($product->InkoopPrijs)
                                        EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Verkoopprijs:</span>
                                <p class="text-gray-900 text-lg font-bold">
                                    @if($product->VerkoopPrijs)
                                        EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Houdbaarheidsdatum:</span>
                                <p class="text-gray-900">
                                    {{ $product->Houdbaarheidsdatum ? $product->Houdbaarheidsdatum->format('d-m-Y') : '-' }}
                                </p>
                            </div>

                            @if($product->voorraad)
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-gray-800 mb-2">Voorraad informatie</h4>
                                <div class="space-y-1 text-sm">
                                    <p><span class="font-medium">Op voorraad:</span> {{ $product->voorraad->AantalOpVoorraad }}</p>
                                    <p><span class="font-medium">Uitgegeven:</span> {{ $product->voorraad->Aantaluitgegeven }}</p>
                                    <p><span class="font-medium">Bijgekomen:</span> {{ $product->voorraad->Aantalbijgekomen }}</p>
                                </div>
                            </div>
                            @else
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 text-sm">Geen voorraad informatie beschikbaar</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Aanvullende informatie -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Aanvullende informatie</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Status:</span>
                                <p class="text-gray-900">
                                    @if($product->IsActief)
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Actief</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Inactief</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Opmerking:</span>
                                <p class="text-gray-900">{{ $product->Opmerking ?? '-' }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Aangemaakt op:</span>
                                <p class="text-gray-900">
                                    {{ $product->DatumAangemaakt ? $product->DatumAangemaakt->format('d-m-Y H:i') : '-' }}
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Laatst gewijzigd:</span>
                                <p class="text-gray-900">
                                    {{ $product->DatumGewijzigd ? $product->DatumGewijzigd->format('d-m-Y H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t flex gap-4">
                    <a 
                        href="{{ route('producten.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition"
                    >
                        Terug naar overzicht
                    </a>
                    <a 
                        href="{{ route('producten.edit', $product->Id) }}" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md font-medium transition"
                    >
                        Bewerken
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-400 text-sm mt-8">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>
