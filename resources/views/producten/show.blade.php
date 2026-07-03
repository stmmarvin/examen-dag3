<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div style="max-width: 800px; margin-left: 2rem; padding-left: 1.5rem; padding-right: 1.5rem;">
            
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
                <span class="text-gray-500">{{ $product->naam }}</span>
            </h1>

            <!-- Success Message -->
            @if(session('success'))
                <div id="success-message" class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
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
            <div class="bg-white rounded shadow-sm p-8">
                <div>
                    
                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Product</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->naam }}</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Merk</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->merk ?? '-' }}</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Omschrijving</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->omschrijving ?? '-' }}</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">EAN-code</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->ean_code ?? '-' }}</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Houdbaarheidsdatum</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">
                            {{ $product->houdbaarheidsdatum ? $product->houdbaarheidsdatum->format('d-m-Y') : '-' }}
                        </div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Inkoopprijs</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">
                            @if($product->inkoop_prijs)
                                EUR {{ number_format($product->inkoop_prijs, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Verkoopprijs</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">
                            @if($product->verkoop_prijs)
                                EUR {{ number_format($product->verkoop_prijs, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Aantal op voorraad</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">{{ $product->voorraad->aantal_op_voorraad ?? '-' }}</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">BarberCare Nederland</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Postcode leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">4811AA</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Plaats leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">Breda</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">E-mail leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">bestellingen@barbercare-nederland.nl</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px; border-bottom: 1px solid #000;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Mobiel leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">+31 623456124</div>
                    </div>

                    <div class="flex py-4" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-semibold text-gray-800">Opmerking</div>
                        <div style="flex: 1;" class="text-sm text-gray-700">Geschikt voor verkoop na baardtrimbehandelingen.</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end gap-4">
                    <a 
                        href="{{ route('producten.edit', $product->id) }}" 
                        class="bg-red-600 hover:bg-red-700 text-white px-8 py-2 rounded-md font-medium transition"
                    >
                        Wijzigen
                    </a>
                    <a 
                        href="{{ route('producten.index') }}" 
                        class="border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white px-8 py-2 rounded-md font-medium transition"
                    >
                        Terug
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
