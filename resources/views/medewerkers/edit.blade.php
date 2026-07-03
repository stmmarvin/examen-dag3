<x-app-layout>
    <div class="flex min-h-[calc(100vh-4rem)] flex-col bg-slate-100 py-10">
        <div class="mx-auto w-full max-w-[1700px] flex-1 px-4 sm:px-6 lg:px-8">
            <div class="mb-6 text-sm">
                <a href="{{ route('dashboard') }}" class="font-semibold text-red-600 hover:text-red-700">Home</a>
                <span class="mx-2 text-slate-400">/</span>
                <a href="{{ route('medewerkers.index') }}" class="font-semibold text-red-600 hover:text-red-700">Medewerkers</a>
                <span class="mx-2 text-slate-400">/</span>
                <span class="font-semibold text-slate-500">Wijzigen</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold text-red-700">
                Medewerker wijzigen <span class="text-slate-500">{{ $medewerker->volledige_naam }}</span>
            </h1>

            <form method="POST" action="{{ route('medewerkers.update', $medewerker) }}" class="max-w-4xl rounded-lg bg-white p-6 shadow-lg">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        Controleer de verplichte velden en probeer het opnieuw.
                    </div>
                @endif

                <div class="grid gap-4 md:grid-cols-2">
                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Naam <span class="text-red-700">*</span></span>
                        <input type="text" name="naam" value="{{ old('naam', $medewerker->volledige_naam) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('naam') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Specialisatie <span class="text-red-700">*</span></span>
                        <select name="specialisatie" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                            @foreach ($specialisaties as $specialisatie)
                                <option value="{{ $specialisatie }}" @selected(old('specialisatie', $medewerker->Specialisatie) === $specialisatie)>
                                    {{ $specialisatie }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialisatie') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Geboortedatum <span class="text-red-700">*</span></span>
                        <input type="date" name="geboortedatum" value="{{ old('geboortedatum', $medewerker->Geboortedatum?->format('Y-m-d')) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('geboortedatum') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Contact e-mail <span class="text-red-700">*</span></span>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $contact?->Email) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('contact_email') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Account e-mail</span>
                        <input type="email" value="{{ $medewerker->user?->email ?? $contact?->Email }}" disabled class="w-full rounded-md border-slate-300 bg-slate-100 text-sm text-slate-500 shadow-sm">
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Straatnaam <span class="text-red-700">*</span></span>
                        <input type="text" name="straatnaam" value="{{ old('straatnaam', $contact?->Straatnaam) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('straatnaam') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-bold text-slate-700">Huisnummer <span class="text-red-700">*</span></span>
                            <input type="text" name="huisnummer" value="{{ old('huisnummer', $contact?->Huisnummer) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                            @error('huisnummer') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-bold text-slate-700">Toevoeging</span>
                            <input type="text" name="toevoeging" value="{{ old('toevoeging', $contact?->Toevoeging) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                            @error('toevoeging') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                        </label>
                    </div>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Postcode <span class="text-red-700">*</span></span>
                        <input type="text" name="postcode" value="{{ old('postcode', $contact?->Postcode) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('postcode') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Plaats <span class="text-red-700">*</span></span>
                        <input type="text" name="plaats" value="{{ old('plaats', $contact?->Plaats) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('plaats') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label>
                        <span class="mb-1 block text-sm font-bold text-slate-700">Mobiel <span class="text-red-700">*</span></span>
                        <input type="text" name="mobiel" value="{{ old('mobiel', $contact?->Mobiel) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('mobiel') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-1 block text-sm font-bold text-slate-700">Opmerking</span>
                        <input type="text" name="opmerking" value="{{ old('opmerking', $medewerker->Opmerking) }}" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-red-600 focus:ring-red-600">
                        @error('opmerking') <span class="mt-1 block text-xs font-semibold text-red-700">{{ $message }}</span> @enderror
                    </label>
                </div>

                <p class="mt-4 text-sm text-slate-500">Velden met een <span class="font-bold text-red-700">*</span> zijn verplicht.</p>

                <div class="mt-5 flex justify-end gap-3">
                    <button type="submit" class="rounded-md bg-red-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-red-800">
                        Opslaan
                    </button>
                    <a href="{{ route('medewerkers.show', $medewerker) }}" class="rounded-md bg-slate-500 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-slate-600">
                        Terug
                    </a>
                </div>
            </form>
        </div>

        <p class="mt-auto px-4 pt-10 text-center text-sm text-slate-400">&copy; 2026 Kniploket Tiko - Alle rechten voorbehouden</p>
    </div>
</x-app-layout>
