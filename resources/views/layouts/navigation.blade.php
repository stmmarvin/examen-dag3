<nav class="bg-red-600 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-6">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl tracking-wider">
                    KNIPLOKET TIKO
                </a>
            </div>

            <!-- Navigation Links - Centered -->
            <div class="flex items-center space-x-8">
                <span class="text-white text-sm font-medium whitespace-nowrap">Accounts</span>
                <span class="text-white text-sm font-medium whitespace-nowrap">Medewerkers</span>
                <span class="text-white text-sm font-medium whitespace-nowrap">Beschikbaarheid</span>
                <a href="{{ route('klanten.index') }}" class="{{ request()->routeIs('klanten.*') ? 'bg-gray-500 text-white' : 'text-white hover:bg-gray-500' }} rounded px-3 py-2 text-sm font-medium whitespace-nowrap transition">
                    Klanten
                </a>
                <span class="text-white text-sm font-medium whitespace-nowrap">Afspraken</span>
                <span class="text-white text-sm font-medium whitespace-nowrap">Behandelingen</span>
                <span class="text-white text-sm font-medium whitespace-nowrap">Producten</span>
                <span class="text-white text-sm font-medium whitespace-nowrap">Bestellingen</span>
            </div>

            <!-- Right side - User info and logout -->
            <div class="flex items-center space-x-6 flex-shrink-0">
                <span class="text-white text-sm whitespace-nowrap">Salon Eigenaar (Eigenaar)</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-red-200 transition text-sm font-medium whitespace-nowrap">
                        Uitloggen
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
