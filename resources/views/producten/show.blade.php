<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700 font-medium">Home</a>
                <span class="text-gray-400 mx-2">/</span>
                <a href="{{ route('producten.index') }}" class="text-red-600 hover:text-red-700 font-medium">Producten</a>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-600">Detail</span>
            </div>

            <!-- Header -->
            <h1 class="text-3xl font-bold mb-6">
                <span class="text-red-600">Productdetail</span>
                <span class="text-gray-400">{{ $product->naam }}</span>
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
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div>
                    
                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Product</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">{{ $product->naam }}</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Merk</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">{{ $product->merk ?? '-' }}</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Omschrijving</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">{{ $product->omschrijving ?? '-' }}</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">EAN-code</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">{{ $product->ean_code ?? '-' }}</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Houdbaarheidsdatum</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">
                            {{ $product->houdbaarheidsdatum ? $product->houdbaarheidsdatum->format('d-m-Y') : '-' }}
                        </div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Inkoopprijs</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">
                            @if($product->inkoop_prijs)
                                EUR {{ number_format($product->inkoop_prijs, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Verkoopprijs</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">
                            @if($product->verkoop_prijs)
                                EUR {{ number_format($product->verkoop_prijs, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Aantal op voorraad</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">{{ $product->voorraad->aantal_op_voorraad ?? '-' }}</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">BarberCare Nederland</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Postcode leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">4811AA</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Plaats leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">Breda</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">E-mail leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">bestellingen@barbercare-nederland.nl</div>
                    </div>

                    <div class="flex py-3 border-b border-gray-300" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Mobiel leverancier</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">+31 623456124</div>
                    </div>

                    <div class="flex py-3" style="gap: 10px;">
                        <div style="width: 33%;" class="text-sm font-medium text-gray-900">Opmerking</div>
                        <div style="flex: 1;" class="text-sm text-gray-600">Geschikt voor verkoop na baardtrimbehandelingen.</div>
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
