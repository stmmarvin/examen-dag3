<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6">
            {{-- Foutmeldingen weergeven --}}
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold">Gegevens niet bijgewerkt</p>
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Breadcrumb navigatie --}}
            <nav class="text-sm mb-6 text-gray-600">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-800">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('behandelingen.index') }}" class="text-red-600 hover:text-red-800">Behandelingen</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800">Wijzigen</span>
            </nav>

            {{-- Pagina titels --}}
            <h1 class="text-3xl font-bold text-red-600 mb-1">Product wijzigen</h1>
            <h2 class="text-lg text-gray-500 mb-6">{{ $product->naam }}</h2>

            <form method="POST" action="{{ route('behandelingen.product.update', [$behandeling->id, $product->id]) }}">
                @csrf
                @method('PUT')

                {{-- Product wijzig formulier in 2 kolommen --}}
                <div class="bg-white rounded shadow-sm p-6 mb-4">
                    <div class="grid grid-cols-2 gap-x-8">
                        {{-- Linker kolom --}}
                        <div>
                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Product</label>
                                <input type="text" value="{{ $product->naam }}" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Omschrijving</label>
                                <input type="text" value="{{ $product->beschrijving }}" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Houdbaarheidsdatum</label>
                                <input type="text" value="01-07-2027" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Inkoopprijs</label>
                                <input type="text" value="EUR {{ number_format($product->prijs * 0.5, 2) }}" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Huidige verkoopprijs</label>
                                <input type="text" value="EUR {{ number_format($product->prijs, 2) }}" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            {{-- Bewerkbaar veld voor nieuwe verkoopprijs --}}
                            <div class="py-4">
                                <label for="verkoopprijs" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Nieuwe verkoopprijs <span class="text-red-600">*</span>
                                </label>
                                <input type="number" step="0.01" name="verkoopprijs" id="verkoopprijs" 
                                       value="{{ old('verkoopprijs', number_format($product->prijs, 2, '.', '')) }}" 
                                       class="w-full text-sm border-gray-300 rounded shadow-sm focus:border-red-500 focus:ring-red-500 @error('verkoopprijs') border-red-500 @enderror">
                                @error('verkoopprijs')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Minimaal 30 procent boven de inkoopprijs.</p>
                            </div>
                        </div>

                        {{-- Rechter kolom --}}
                        <div>
                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Merk</label>
                                <input type="text" value="Tiko Care" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">EAN-code</label>
                                <input type="text" value="{{ $product->sku }}" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Aantal op voorraad</label>
                                <input type="text" value="{{ $product->voorraad }}" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Leverancier</label>
                                <input type="text" value="Van Duuren Haircosmetics" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4 border-b border-gray-300">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Plaats leverancier</label>
                                <input type="text" value="Utrecht" disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>

                            <div class="py-4">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Opmerking</label>
                                <input type="text" value="Geschikt voor dagelijks salongebruik." disabled 
                                       class="w-full text-sm border-gray-300 bg-gray-50 text-gray-500 rounded shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mb-4">Velden met een * zijn verplicht.</p>

                {{-- Actie knoppen --}}
                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded text-sm">
                        Opslaan
                    </button>
                    <a href="{{ route('behandelingen.product.detail', [$behandeling->id, $product->id]) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm inline-block">
                        Terug
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
