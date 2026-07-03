<x-app-layout>
    <div class="min-h-screen bg-slate-100 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 text-sm">
                <a href="{{ route('dashboard') }}" class="font-semibold text-red-600 hover:text-red-700">Home</a>
                <span class="mx-2 text-slate-400">/</span>
                <span class="font-semibold text-slate-500">Medewerkers</span>
            </div>

            <h1 class="mb-3 text-2xl font-bold text-red-700">Overzicht medewerkers</h1>

            <section class="mb-4 rounded-lg bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 md:ml-auto md:max-w-xl md:flex-row md:items-end">
                    <label class="flex-1">
                        <span class="mb-1 block text-xs font-bold text-slate-700">Specialisatie</span>
                        <select class="w-full rounded-md border-slate-300 text-sm text-slate-600 shadow-sm focus:border-red-600 focus:ring-red-600">
                            <option>Alle specialisaties</option>
                            <option>Stylen</option>
                            <option>Knippen</option>
                            <option>Extensions</option>
                            <option>Kleuren</option>
                        </select>
                    </label>

                    <button type="button" class="rounded-md bg-red-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-red-800">
                        Toon medewerkers
                    </button>

                    <button type="button" class="rounded-md bg-slate-500 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-slate-600">
                        Reset
                    </button>
                </div>
            </section>

            <section class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="flex flex-col gap-3 px-4 py-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-slate-500">Gevonden medewerkers - 10 medewerker(s)</p>

                    <div class="flex items-center justify-center gap-2">
                        <button type="button" class="h-9 w-9 rounded-md border border-slate-200 text-sm font-semibold text-slate-300">&lsaquo;</button>
                        <button type="button" class="h-9 w-9 rounded-md bg-red-700 text-sm font-bold text-white">1</button>
                        <button type="button" class="h-9 w-9 rounded-md border border-slate-200 text-sm font-semibold text-red-700">2</button>
                        <button type="button" class="h-9 w-9 rounded-md border border-slate-200 text-sm font-semibold text-red-700">3</button>
                        <button type="button" class="h-9 w-9 rounded-md border border-slate-200 text-sm font-semibold text-red-700">&rsaquo;</button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-left text-sm">
                        <thead class="bg-red-700 text-white">
                            <tr>
                                <th class="px-4 py-3 font-bold">Naam</th>
                                <th class="px-4 py-3 font-bold">Specialisatie</th>
                                <th class="px-4 py-3 font-bold">Adres</th>
                                <th class="px-4 py-3 font-bold">Postcode</th>
                                <th class="px-4 py-3 font-bold">Woonplaats</th>
                                <th class="px-4 py-3 font-bold">Mobiel</th>
                                <th class="px-4 py-3 font-bold">Contact e-mail</th>
                                <th class="px-4 py-3 text-center font-bold">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">Aylin Demir</td>
                                <td class="whitespace-nowrap px-4 py-3">Stylen</td>
                                <td class="whitespace-nowrap px-4 py-3">Laan van Nieuw-Guinea 141</td>
                                <td class="whitespace-nowrap px-4 py-3">3531JE</td>
                                <td class="whitespace-nowrap px-4 py-3">Utrecht</td>
                                <td class="whitespace-nowrap px-4 py-3">0611111117</td>
                                <td class="whitespace-nowrap px-4 py-3">aylin.demir@kniplokettiko.nl</td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="rounded-md border border-blue-500 px-4 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-500 hover:text-white">Details</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">Fatima El Amrani</td>
                                <td class="whitespace-nowrap px-4 py-3">Knippen</td>
                                <td class="whitespace-nowrap px-4 py-3">Kanaalstraat 12</td>
                                <td class="whitespace-nowrap px-4 py-3">3511AB</td>
                                <td class="whitespace-nowrap px-4 py-3">Utrecht</td>
                                <td class="whitespace-nowrap px-4 py-3">0612345678</td>
                                <td class="whitespace-nowrap px-4 py-3">fatima@kniplokettiko.nl</td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="rounded-md border border-blue-500 px-4 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-500 hover:text-white">Details</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">Kevin Smit</td>
                                <td class="whitespace-nowrap px-4 py-3">Extensions</td>
                                <td class="whitespace-nowrap px-4 py-3">Bernardlaan 7</td>
                                <td class="whitespace-nowrap px-4 py-3">3527GA</td>
                                <td class="whitespace-nowrap px-4 py-3">Utrecht</td>
                                <td class="whitespace-nowrap px-4 py-3">0611111116</td>
                                <td class="whitespace-nowrap px-4 py-3">kevin.smit@kniplokettiko.nl</td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="rounded-md border border-blue-500 px-4 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-500 hover:text-white">Details</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">Lisa van Dijk</td>
                                <td class="whitespace-nowrap px-4 py-3">Stylen</td>
                                <td class="whitespace-nowrap px-4 py-3">Maliebaan 17</td>
                                <td class="whitespace-nowrap px-4 py-3">3581CC</td>
                                <td class="whitespace-nowrap px-4 py-3">Utrecht</td>
                                <td class="whitespace-nowrap px-4 py-3">0611111113</td>
                                <td class="whitespace-nowrap px-4 py-3">lisa.vandijk@kniplokettiko.nl</td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="rounded-md border border-blue-500 px-4 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-500 hover:text-white">Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <p class="mt-24 text-center text-sm text-slate-400">&copy; 2026 Kniploket Tiko - Alle rechten voorbehouden</p>
        </div>
    </div>
</x-app-layout>
