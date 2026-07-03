<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div style="max-width: 850px; margin-left: 3rem; padding-left: 2rem; padding-right: 2rem;">
            
            <!-- Breadcrumb -->
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700 font-semibold text-sm">Home</a>
                <span class="text-gray-500 mx-3">/</span>
                <a href="{{ route('producten.index') }}" class="text-red-600 hover:text-red-700 font-semibold text-sm">Producten</a>
                <span class="text-gray-500 mx-3">/</span>
                <span class="text-gray-700 text-sm">Detail</span>
            </div>

            <!-- Header -->
            <h1 class="text-4xl font-bold mb-8">
                <span class="text-red-600">Productdetail</span>
                <span class="text-gray-500">{{ $product->Naam }}</span>
            </h1>

            <!-- Success Message -->
            @if(session('success'))
                <div id="success-message" class="bg-green-100 border-l-4 border-green-600 p-4 mb-6 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        var msg = document.getElementById('success-message');
                        if(msg) {
                            msg.style.transition = 'opacity 0.5s';
                            msg.style.opacity = '0';
                            setTimeout(function() {
                                msg.remove();
                            }, 500);
                        }
                    }, 3000);
                </script>
            @endif

            <!-- Product Details Card -->
            <div class="bg-white rounded shadow-md p-10 border border-gray-200">
                <div>
                    
                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Product</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->Naam }}</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Merk</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->Merk ?? '-' }}</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Omschrijving</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->Omschrijving ?? '-' }}</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">EAN-code</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->EANcode ?? '-' }}</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Houdbaarheidsdatum</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">
                            {{ $product->Houdbaarheidsdatum ? $product->Houdbaarheidsdatum->format('d-m-Y') : '-' }}
                        </div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Inkoopprijs</div>
                        <div style="flex: 1;" class="text-sm font-semibold text-green-700">
                            @if($product->InkoopPrijs)
                                € {{ number_format($product->InkoopPrijs, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Verkoopprijs</div>
                        <div style="flex: 1;" class="text-sm font-semibold text-green-700">
                            @if($product->VerkoopPrijs)
                                € {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Aantal op voorraad</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->voorraad ? $product->voorraad->AantalOpVoorraad : '-' }}</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">BarberCare Nederland</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Postcode leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">4811AA</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Plaats leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">Breda</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">E-mail leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">bestellingen@barbercare-nederland.nl</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Mobiel leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">+31 623456124</div>
                    </div>

                    <div class="flex py-4 hover:bg-gray-50 transition-colors" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Opmerking</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->Opmerking ?? 'Geschikt voor verkoop na baardtrimbehandelingen.' }}</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-10 flex justify-end gap-4">
                    <a 
                        href="{{ route('producten.edit', $product->Id) }}" 
                        class="bg-red-600 hover:bg-red-700 text-white px-10 py-3 rounded-md font-semibold transition shadow-sm hover:shadow-md"
                    >
                        Wijzigen
                    </a>
                    <a 
                        href="{{ route('producten.index') }}" 
                        class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-10 py-3 rounded-md font-semibold transition"
                    >
                        Terug
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-500 text-xs mt-12 py-4 border-t border-gray-300">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>
