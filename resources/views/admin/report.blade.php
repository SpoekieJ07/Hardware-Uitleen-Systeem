<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rapportage</h1>
            <p class="text-sm text-gray-500">Overzicht van uitleengegevens en meest gebruikte items.</p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                Terug naar Dashboard
            </a>

            <a href="{{ route('admin.export.history') }}"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 transition">
                Exporteer CSV
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Totaal</p>
            <p class="text-2xl font-bold">{{ $totalLoans }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold">{{ $pendingCount }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Goedgekeurd</p>
            <p class="text-2xl font-bold">{{ $approvedCount }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Afgewezen</p>
            <p class="text-2xl font-bold">{{ $rejectedCount }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Teruggebracht</p>
            <p class="text-2xl font-bold">{{ $returnedCount }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Te laat</p>
            <p class="text-2xl font-bold text-red-600">{{ $overdueCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b bg-gray-50 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">Top 5 meest uitgeleende items</h2>
            </div>

            <table class="w-full text-left">
                <thead class="bg-gray-50 text-sm text-gray-600">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Hardware</th>
                        <th class="px-6 py-3 font-semibold">Totaal uitgeleend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($topHardware as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $item->hardware->name ?? 'Onbekend' }}</td>
                        <td class="px-6 py-4">{{ $item->total_quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-500">Nog geen data beschikbaar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b bg-gray-50 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">Laatste 10 uitleenrecords</h2>
            </div>

            <table class="w-full text-left">
                <thead class="bg-gray-50 text-sm text-gray-600">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Hardware</th>
                        <th class="px-6 py-3 font-semibold">Gebruiker</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach($recentLoans as $loan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loan->hardware->name ?? 'Onbekend' }}</td>
                        <td class="px-6 py-4">{{ $loan->borrower_name }}</td>
                        <td class="px-6 py-4">{{ $loan->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>