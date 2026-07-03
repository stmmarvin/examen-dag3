<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grote container kaart -->
            <div class="bg-gray-50 rounded-2xl shadow-lg p-12">
                <div class="mb-6 bg-yellow-400 text-black px-4 py-2 rounded inline-block font-semibold text-sm">
                    Kapsalon applicatie
                </div>

                <h1 class="text-4xl font-bold mb-2 text-gray-700">Eigenaar</h1>
                <p class="text-gray-500 mb-6 text-sm">Home</p>
                
                <p class="text-gray-400 mb-16">Welkom bij Kniploket Tiko - hier regel je eenvoudig klanten, afspraken en planning voor de salon.</p>

                <!-- Grid met cards - 2 rijen van 4 -->
                <div class="grid grid-cols-4 gap-6">
                
                    <!-- Accounts Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Accounts</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Beheer gebruikersaccounts en rolniveringen.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                    <!-- Medewerkers Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Medewerkers</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Overzicht van medewerkers en hun basisgegevens.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                    <!-- Beschikbaarheid Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Beschikbaarheid</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Bekijk de beschikbaarheid van medewerkers per dag en tijd.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                    <!-- Klanten Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Klanten</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Bekijk en filter klantgegevens op postcode en contactinformatie.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                    <!-- Afspraken Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Afspraken</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Plan, bekijk en beheer afspraken met status en tijd.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                    <!-- Behandelingen Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Behandelingen</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Overzicht van behandelingen, duur en prijsinformatie.</p>
                        <a href="{{ route('behandelingen.index') }}" class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </a>
                    </div>

                    <!-- Producten Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Producten</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Bekijk en beheer producten binnen het assortiment.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                    <!-- Bestellingen Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Bestellingen</h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Bekijk en beheer klantbestellingen en bestelstatus.</p>
                        <button class="inline-block border-2 border-blue-500 text-blue-500 px-6 py-2 rounded text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                            Openen
                        </button>
                    </div>

                </div>
            </div>

            <div class="text-center text-gray-400 text-sm mt-8">
                Â© 2025 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>