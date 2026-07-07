<x-app-layout>
    <div class="min-h-screen bg-gray-100 pb-12">
        <div class="max-w-6xl mx-auto px-6 pt-10">
            @if (session('error'))
                <div class="mb-6 max-w-3xl rounded-md border border-red-200 bg-red-100 px-4 py-4 text-sm text-red-900">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-5 text-sm font-semibold">
                <a href="{{ route('dashboard') }}" class="text-red-600">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <a href="{{ route('klanten.index') }}" class="text-red-600">Klanten</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-500">Wijzigen</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold">
                <span class="text-red-600">Klant wijzigen</span>
                <span class="text-gray-500">{{ $klant->volledige_naam }}</span>
            </h1>

            <form method="POST" action="{{ route('klanten.update', $klant->Id) }}" class="w-full max-w-3xl rounded-xl bg-white p-5 shadow-sm">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="naam" class="mb-1 block text-sm font-semibold text-gray-700">Naam <span class="text-red-600">*</span></label>
                        <input id="naam" name="naam" type="text" value="{{ old('naam', $klant->volledige_naam) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                        <x-input-error :messages="$errors->get('naam')" class="mt-2" />
                    </div>

                    <div>
                        <label for="relatienummer" class="mb-1 block text-sm font-semibold text-gray-700">Relatienummer</label>
                        <input id="relatienummer" type="text" value="{{ $klant->relatienummer }}" disabled class="w-full rounded-md border-gray-300 bg-gray-100 text-sm text-gray-500 shadow-sm">
                    </div>

                    <div>
                        <label for="contact_email" class="mb-1 block text-sm font-semibold text-gray-700">Contact e-mail <span class="text-red-600">*</span></label>
                        <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $contact->Email) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500 @error('contact_email') border-red-500 @enderror">
                        <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="account_email" class="mb-1 block text-sm font-semibold text-gray-700">Account e-mail</label>
                        <input id="account_email" type="email" value="{{ $klant->user?->email }}" disabled class="w-full rounded-md border-gray-300 bg-gray-100 text-sm text-gray-500 shadow-sm">
                    </div>

                    <div>
                        <label for="straatnaam" class="mb-1 block text-sm font-semibold text-gray-700">Straatnaam <span class="text-red-600">*</span></label>
                        <input id="straatnaam" name="straatnaam" type="text" value="{{ old('straatnaam', $contact->Straatnaam) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                        <x-input-error :messages="$errors->get('straatnaam')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="huisnummer" class="mb-1 block text-sm font-semibold text-gray-700">Huisnummer <span class="text-red-600">*</span></label>
                            <input id="huisnummer" name="huisnummer" type="text" value="{{ old('huisnummer', $contact->Huisnummer) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                            <x-input-error :messages="$errors->get('huisnummer')" class="mt-2" />
                        </div>
                        <div>
                            <label for="toevoeging" class="mb-1 block text-sm font-semibold text-gray-700">Toevoeging</label>
                            <input id="toevoeging" name="toevoeging" type="text" value="{{ old('toevoeging', $contact->Toevoeging) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                            <x-input-error :messages="$errors->get('toevoeging')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="postcode" class="mb-1 block text-sm font-semibold text-gray-700">Postcode <span class="text-red-600">*</span></label>
                        <input id="postcode" name="postcode" type="text" value="{{ old('postcode', $contact->Postcode) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                        <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
                    </div>

                    <div>
                        <label for="plaats" class="mb-1 block text-sm font-semibold text-gray-700">Plaats <span class="text-red-600">*</span></label>
                        <input id="plaats" name="plaats" type="text" value="{{ old('plaats', $contact->Plaats) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                        <x-input-error :messages="$errors->get('plaats')" class="mt-2" />
                    </div>

                    <div>
                        <label for="mobiel" class="mb-1 block text-sm font-semibold text-gray-700">Mobiel <span class="text-red-600">*</span></label>
                        <input id="mobiel" name="mobiel" type="text" value="{{ old('mobiel', $contact->Mobiel) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                        <x-input-error :messages="$errors->get('mobiel')" class="mt-2" />
                    </div>

                    <div class="col-span-2">
                        <label for="bijzonderheden" class="mb-1 block text-sm font-semibold text-gray-700">Bijzonderheden</label>
                        <input id="bijzonderheden" name="bijzonderheden" type="text" value="{{ old('bijzonderheden', $klant->bijzonderheden) }}" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                        <x-input-error :messages="$errors->get('bijzonderheden')" class="mt-2" />
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-500">Velden met een <span class="font-bold text-red-600">*</span> zijn verplicht.</p>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="submit" class="rounded-md bg-red-600 px-5 py-2 text-sm font-bold text-white hover:bg-red-700">
                        Opslaan
                    </button>
                    <a href="{{ $klant->Id == 5 ? route('klanten.details') : route('klanten.show', $klant->Id) }}" class="rounded-md bg-gray-500 px-5 py-2 text-sm font-bold text-white hover:bg-gray-600">
                        Terug
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
