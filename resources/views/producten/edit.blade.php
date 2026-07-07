<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700 font-medium">Home</a>
                <span class="text-gray-400 mx-2">/</span>
                <a href="{{ route('producten.index') }}" class="text-red-600 hover:text-red-700 font-medium">Producten</a>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-600">Wijzigen</span>
            </div>

            <!-- Header -->
            <h1 class="text-3xl font-bold mb-6">
                <span class="text-red-600">Product wijzigen</span>
                <span class="text-gray-400">{{ $product->naam }}</span>
            </h1>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            @if($errors->has('general'))
                                {{ $errors->first('general') }}
                            @else
                                Er zijn fouten opgetreden
                            @endif
                        </h3>
                        @if($errors->count() > 1 || !$errors->has('general'))
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    @if(!str_contains($error, 'Gegevens niet bijgewerkt'))
                                        <li>{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <form method="POST" action="{{ route('producten.update', $product->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Row 1 -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 12px;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                            <input type="text" value="{{ $product->naam }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                            <input type="text" value="{{ $product->merk }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 12px;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Omschrijving</label>
                            <input type="text" value="{{ $product->omschrijving }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">EAN-code</label>
                            <input type="text" value="{{ $product->ean_code }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 12px;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Inkoopprijs</label>
                            <input type="text" value="{{ $product->inkoop_prijs ? 'EUR ' . number_format($product->inkoop_prijs, 2, ',', '.') : '-' }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Aantal op voorraad</label>
                            <input type="text" value="{{ $product->voorraad ? $product->voorraad->AantalOpVoorraad : 0 }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 12px;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Huidige verkoopprijs</label>
                            <input type="text" value="{{ $product->verkoop_prijs ? 'EUR ' . number_format($product->verkoop_prijs, 2, ',', '.') : '-' }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Leverancier</label>
                            <input type="text" value="BarberCare Nederland" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                    </div>

                    <!-- Row 5 -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 12px;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Houdbaarheidsdatum</label>
                            <input type="text" value="{{ $product->houdbaarheidsdatum ? $product->houdbaarheidsdatum->format('d-m-Y') : '-' }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Plaats leverancier</label>
                            <input type="text" value="Breda" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                    </div>

                    <!-- Row 6 -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 12px;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nieuwe houdbaarheidsdatum <span class="text-red-600">*</span></label>
                            <input type="date" name="nieuwe_houdbaarheidsdatum" value="{{ old('nieuwe_houdbaarheidsdatum', $product->houdbaarheidsdatum ? $product->houdbaarheidsdatum->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm @error('nieuwe_houdbaarheidsdatum') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">De houdbaarheidsdatum mag uiterlijk met 7 dagen worden verlengd.</p>
                            @error('nieuwe_houdbaarheidsdatum')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Opmerking</label>
                            <input type="text" value="{{ $product->opmerking ?? 'Geschikt voor verkoop na baardtrimbehandelingen.' }}" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm bg-gray-100" readonly>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-4 mb-4">Velden met een * zijn verplicht.</p>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-4">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-2 rounded-md font-medium">Opslaan</button>
                        <a href="{{ route('producten.show', $product->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-2 rounded-md font-medium inline-block">Terug</a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-400 text-sm mt-8">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>
