<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700 font-medium">Home</a>
                <span class="text-gray-400 mx-2">/</span>
                <a href="{{ route('producten.index') }}" class="text-red-600 hover:text-red-700 font-medium">Producten</a>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-600">Nieuw product</span>
            </div>

            <!-- Header -->
            <h1 class="text-3xl font-bold text-red-600 mb-6">Nieuw product toevoegen</h1>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <form method="POST" action="{{ route('producten.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Product naam -->
                        <div>
                            <label for="Naam" class="block text-sm font-medium text-gray-700 mb-2">
                                Product naam <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="Naam" 
                                id="Naam" 
                                value="{{ old('Naam') }}"
                                required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('Naam')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categorie -->
                        <div>
                            <label for="CategorieId" class="block text-sm font-medium text-gray-700 mb-2">
                                Categorie
                            </label>
                            <select 
                                name="CategorieId" 
                                id="CategorieId" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                                <option value="">Selecteer categorie</option>
                                @foreach($categorieen as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('CategorieId') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->naam }}
                                    </option>
                                @endforeach
                            </select>
                            @error('CategorieId')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Merk -->
                        <div>
                            <label for="Merk" class="block text-sm font-medium text-gray-700 mb-2">
                                Merk
                            </label>
                            <input 
                                type="text" 
                                name="Merk" 
                                id="Merk" 
                                value="{{ old('Merk') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('Merk')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- EAN-code -->
                        <div>
                            <label for="EANcode" class="block text-sm font-medium text-gray-700 mb-2">
                                EAN-code
                            </label>
                            <input 
                                type="text" 
                                name="EANcode" 
                                id="EANcode" 
                                value="{{ old('EANcode') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('EANcode')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Inkoopprijs -->
                        <div>
                            <label for="InkoopPrijs" class="block text-sm font-medium text-gray-700 mb-2">
                                Inkoopprijs (EUR)
                            </label>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="InkoopPrijs" 
                                id="InkoopPrijs" 
                                value="{{ old('InkoopPrijs') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('InkoopPrijs')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Verkoopprijs -->
                        <div>
                            <label for="VerkoopPrijs" class="block text-sm font-medium text-gray-700 mb-2">
                                Verkoopprijs (EUR)
                            </label>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="VerkoopPrijs" 
                                id="VerkoopPrijs" 
                                value="{{ old('VerkoopPrijs') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('VerkoopPrijs')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Houdbaarheidsdatum -->
                        <div>
                            <label for="Houdbaarheidsdatum" class="block text-sm font-medium text-gray-700 mb-2">
                                Houdbaarheidsdatum
                            </label>
                            <input 
                                type="date" 
                                name="Houdbaarheidsdatum" 
                                id="Houdbaarheidsdatum" 
                                value="{{ old('Houdbaarheidsdatum') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('Houdbaarheidsdatum')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opmerking -->
                        <div>
                            <label for="Opmerking" class="block text-sm font-medium text-gray-700 mb-2">
                                Opmerking
                            </label>
                            <input 
                                type="text" 
                                name="Opmerking" 
                                id="Opmerking" 
                                value="{{ old('Opmerking') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >
                            @error('Opmerking')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Omschrijving (full width) -->
                        <div class="md:col-span-2">
                            <label for="Omschrijving" class="block text-sm font-medium text-gray-700 mb-2">
                                Omschrijving
                            </label>
                            <textarea 
                                name="Omschrijving" 
                                id="Omschrijving" 
                                rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                            >{{ old('Omschrijving') }}</textarea>
                            @error('Omschrijving')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 pt-6 border-t flex gap-4">
                        <a 
                            href="{{ route('producten.index') }}" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition"
                        >
                            Annuleren
                        </a>
                        <button 
                            type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition"
                        >
                            Product toevoegen
                        </button>
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
