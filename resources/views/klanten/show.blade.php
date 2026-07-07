<x-app-layout>
    <div class="min-h-screen bg-gray-100 pb-12">
        <div class="max-w-6xl mx-auto px-6 pt-10">
            <div class="mb-5 text-sm font-semibold">
                <a href="{{ route('dashboard') }}" class="text-red-600">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <a href="{{ route('klanten.index') }}" class="text-red-600">Klanten</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-500">Detail</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold">
                <span class="text-red-600">Klantdetail</span>
                <span class="text-gray-500">{{ $klant->volledige_naam }}</span>
            </h1>

            <div class="w-full max-w-2xl rounded-xl bg-white p-4 shadow-sm">
                <dl class="text-sm">
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Naam</dt>
                        <dd class="col-span-2 text-gray-700">{{ $klant->volledige_naam }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Relatienummer</dt>
                        <dd class="col-span-2 text-gray-700">{{ $klant->relatienummer }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Contact e-mail</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->email }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Account e-mail</dt>
                        <dd class="col-span-2 text-gray-700">{{ $klant->user?->email }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Straatnaam</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->straatnaam }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Huisnummer</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->huisnummer }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Toevoeging</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->toevoeging ?: '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Postcode</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->postcode }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Plaats</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->plaats }}</dd>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-200 py-2">
                        <dt class="font-bold text-gray-800">Mobiel</dt>
                        <dd class="col-span-2 text-gray-700">{{ $contact->mobiel }}</dd>
                    </div>
                    <div class="grid grid-cols-3 py-2">
                        <dt class="font-bold text-gray-800">Bijzonderheden</dt>
                        <dd class="col-span-2 text-gray-700">{{ $klant->bijzonderheden }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ $klant->id == 5 ? route('klanten.details.edit') : route('klanten.edit', $klant->id) }}" class="rounded-md bg-red-600 px-5 py-2 text-sm font-bold text-white hover:bg-red-700">
                        Wijzigen
                    </a>
                    <a href="{{ route('klanten.index') }}" class="rounded-md border border-blue-500 px-5 py-2 text-sm font-bold text-blue-600 hover:bg-blue-500 hover:text-white">
                        Terug
                    </a>
                </div>
            </div>

            <div class="mt-16 text-center text-sm text-gray-400">
                &copy; 2026 Kniploket Tiko - Alle rechten voorbehouden
            </div>
        </div>
    </div>
</x-app-layout>
