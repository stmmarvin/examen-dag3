<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6">
            <!-- Success Message -->
            @if(session('success'))
                <div id="success-message" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        const message = document.getElementById('success-message');
                        if (message) {
                            message.style.transition = 'opacity 0.5s';
                            message.style.opacity = '0';
                            setTimeout(() => message.remove(), 500);
                        }
                    }, 3000);
                </script>
            @endif

            <!-- Breadcrumb -->
            <nav class="text-sm mb-6 text-gray-600">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-800">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('behandelingen.index') }}" class="text-red-600 hover:text-red-800">Behandelingen</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800">Detail</span>
            </nav>

            <!-- Titles outside -->
            <h1 class="text-3xl font-bold text-red-600 mb-1">Productdetail</h1>
            <h2 class="text-lg text-gray-500 mb-6">{{ $product->naam }}</h2>

            <!-- Single white container with all fields -->
            <div class="bg-white rounded shadow-sm p-6 mb-6">
                <div class="grid grid-cols-2 gap-x-8">
                    <!-- Left Column -->
                    <div>
                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Product</div>
                            <div class="text-sm text-gray-600">{{ $product->naam }}</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Merk</div>
                            <div class="text-sm text-gray-600">Tiko Care</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Omschrijving</div>
                            <div class="text-sm text-gray-600">{{ $product->beschrijving }}</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">EAN-code</div>
                            <div class="text-sm text-gray-600">{{ $product->sku }}</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Houdbaarheidsdatum</div>
                            <div class="text-sm text-gray-600">01-07-2027</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Inkoopprijs</div>
                            <div class="text-sm text-gray-600">EUR {{ number_format($product->prijs * 0.5, 2) }}</div>
                        </div>

                        <div class="py-4">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Verkoopprijs</div>
                            <div class="text-sm text-gray-600">EUR {{ number_format($product->prijs, 2) }}</div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Aantal op voorraad</div>
                            <div class="text-sm text-gray-600">{{ $product->voorraad }}</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Leverancier</div>
                            <div class="text-sm text-gray-600">Van Duuren Haircosmetics</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Postcode leverancier</div>
                            <div class="text-sm text-gray-600">3584AN</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Plaats leverancier</div>
                            <div class="text-sm text-gray-600">Utrecht</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">E-mail leverancier</div>
                            <div class="text-sm text-gray-600">inkoop@vanduurenhaircosmetics.nl</div>
                        </div>

                        <div class="py-4 border-b border-gray-300">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Mobiel leverancier</div>
                            <div class="text-sm text-gray-600">+31 623456121</div>
                        </div>

                        <div class="py-4">
                            <div class="text-xs font-semibold text-gray-700 mb-1">Opmerking</div>
                            <div class="text-sm text-gray-600">Geschikt voor dagelijks salongebruik.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons outside container -->
            <div class="flex gap-3">
                <a href="{{ route('behandelingen.product.edit', [$behandeling->id, $product->id]) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded text-sm">
                    Wijzigen
                </a>
                <a href="{{ route('behandelingen.producten', $behandeling->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm">
                    Terug
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
