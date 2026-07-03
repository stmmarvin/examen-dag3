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
                <a href="{{ route('medewerkers.index') }}" class="{{ request()->routeIs('medewerkers.*') ? 'bg-red-700' : '' }} text-white hover:bg-red-700 rounded px-3 py-2 text-sm font-medium whitespace-nowrap transition">
                    Medewerkers
                </a>
                <span class="text-white text-sm font-medium whitespace-nowrap">Beschikbaarheid</span>
                <a href="{{ route('klanten.index') }}" class="{{ request()->routeIs('klanten.*') ? 'bg-red-700' : '' }} text-white hover:bg-red-700 rounded px-3 py-2 text-sm font-medium whitespace-nowrap transition">
                    Klanten
                </a>
                <span class="text-white text-sm font-medium whitespace-nowrap">Afspraken</span>
                <a href="{{ route('behandelingen.index') }}" class="{{ request()->routeIs('behandelingen.*') ? 'bg-red-700' : '' }} text-white hover:bg-red-700 rounded px-3 py-2 text-sm font-medium whitespace-nowrap transition">
                    Behandelingen
                </a>
                <a href="{{ route('producten.index') }}" class="{{ request()->routeIs('producten.*') ? 'bg-red-700' : '' }} text-white hover:bg-red-700 rounded px-3 py-2 text-sm font-medium whitespace-nowrap transition">
                    Producten
                </a>
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
