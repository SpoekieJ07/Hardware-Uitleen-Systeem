<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Uitleen overzicht</h1>
                <p class="text-sm text-gray-500">Beheer hardware die je kunt uitlenen en innemen.</p>
            </div>

            <div class="flex gap-2">
                {{-- Optioneel: knop naar hardware lijst --}}
                <a href="{{ route('hardware.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Hardware beheren
                </a>

                {{-- Optioneel: nieuwe uitleen --}}
                {{-- <a href="{{ route('uitleen.create') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 shadow">
                    + Nieuwe uitleen
                </a> --}}
            </div>
        </div>

        {{-- Stats --}}
        @php
            $totalItems = $hardwares->count();
            $availableItems = $hardwares->filter(fn($h) => (int)($h->total ?? 0) > 0)->count();
            $loanedItems = $totalItems - $availableItems;
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Totaal items</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalItems }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Beschikbaar</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $availableItems }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Uitgeleend / Niet beschikbaar</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $loanedItems }}</p>
            </div>
        </div>

        {{-- Controls --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative w-full sm:max-w-md">
                    <input id="search"
                           type="text"
                           placeholder="Zoek op naam, prijs, aantal…"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    <div class="pointer-events-none absolute right-3 top-2.5 text-gray-400">
                        ⌕
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button id="filterAll"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Alles
                    </button>
                    <button id="filterAvailable"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Beschikbaar
                    </button>
                    <button id="filterLoaned"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Niet beschikbaar
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <tr>
                            <th class="px-5 py-3">Hardware</th>
                            <th class="px-5 py-3">Aantal</th>
                            <th class="px-5 py-3">Prijs</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Acties</th>
                        </tr>
                    </thead>

                    <tbody id="rows" class="divide-y">
                        @forelse($hardwares as $hardware)
                            @php
                                $qty = (int)($hardware->total ?? 0);
                                $available = $qty > 0;
                            @endphp

                            <tr class="row"
                                data-search="{{ strtolower($hardware->name.' '.$qty.' '.$hardware->price) }}"
                                data-status="{{ $available ? 'available' : 'loaned' }}">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900">{{ $hardware->name }}</div>
                                    <div class="text-xs text-gray-500">ID #{{ $hardware->id }}</div>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="font-semibold text-gray-900">{{ $qty }}</span>
                                </td>

                                <td class="px-5 py-4">
                                    € {{ number_format((float)($hardware->price ?? 0), 2, ',', '.') }}
                                </td>

                                <td class="px-5 py-4">
                                    @if($available)
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                            Beschikbaar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                            Niet beschikbaar
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('hardware.show', $hardware->id) }}"
                                           class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                            Details
                                        </a>

                                        {{-- Uitleen knop (alleen als beschikbaar) --}}
                                        @if($available)
                                            {{-- Pas deze route aan naar jouw project: uitleen.create / uitleen.store / etc --}}
                                            <a href="{{ route('uitleen.create', ['hardware_id' => $hardware->id]) }}"
                                               class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700 shadow">
                                                Uitleen
                                            </a>
                                        @else
                                            {{-- Retour knop (pas aan naar jouw route) --}}
                                            <a href="{{ route('uitleen.return', $hardware->id) }}"
                                               class="rounded-lg bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800 shadow">
                                                Retour
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center">
                                    <div class="text-gray-900 font-semibold">Nog geen hardware gevonden</div>
                                    <div class="text-sm text-gray-500">Voeg eerst hardware toe, daarna kun je uitlenen.</div>
                                    <div class="mt-4">
                                        <a href="{{ route('hardware.create') }}"
                                           class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 shadow">
                                            + Hardware toevoegen
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div id="emptyState" class="hidden border-t bg-white px-5 py-6 text-center text-sm text-gray-500">
                Geen resultaten voor je filter/zoekopdracht.
            </div>
        </div>

    </div>

    {{-- Simple front-end filtering --}}
    <script>
        (function () {
            const search = document.getElementById('search');
            const rows = Array.from(document.querySelectorAll('.row'));
            const empty = document.getElementById('emptyState');

            let statusFilter = 'all';

            const apply = () => {
                const q = (search.value || '').toLowerCase().trim();
                let visible = 0;

                rows.forEach(r => {
                    const matchesSearch = r.dataset.search.includes(q);
                    const matchesStatus =
                        statusFilter === 'all' ||
                        r.dataset.status === statusFilter;

                    const show = matchesSearch && matchesStatus;
                    r.classList.toggle('hidden', !show);
                    if (show) visible++;
                });

                empty.classList.toggle('hidden', visible !== 0);
            };

            document.getElementById('filterAll').addEventListener('click', () => { statusFilter = 'all'; apply(); });
            document.getElementById('filterAvailable').addEventListener('click', () => { statusFilter = 'available'; apply(); });
            document.getElementById('filterLoaned').addEventListener('click', () => { statusFilter = 'loaned'; apply(); });

            search.addEventListener('input', apply);
            apply();
        })();
    </script>
</x-app-layout>
