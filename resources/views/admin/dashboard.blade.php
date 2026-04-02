<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Dashboard</h1>
    <p class="text-gray-600 mb-6">Welkom op je dashboard. Hier zie je de belangrijkste uitleengegevens.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Totaal uitleenrecords</p>
            <p class="text-2xl font-bold">{{ $stats['total_loans'] }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold">{{ $stats['pending_count'] }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Goedgekeurd</p>
            <p class="text-2xl font-bold">{{ $stats['approved_count'] }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Teruggebracht</p>
            <p class="text-2xl font-bold">{{ $stats['returned_count'] }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Te laat</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['overdue_count'] }}</p>
        </div>
        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Defecte items</p>
            <p class="text-2xl font-bold">{{ $stats['defective_count'] }}</p>
        </div>
    </div>

    <div class="mt-6 mb-6 flex flex-wrap gap-4">
        <a href="{{ route('admin.pending') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
            Pending verzoeken
        </a>
        <a href="{{ route('admin.hardware.index') }}" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700 transition">
            Hardware index
        </a>
        <a href="{{ route('admin.overdue') }}" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-700 transition">
            Te late items
        </a>
        <a href="{{ route('admin.calendar') }}" class="inline-flex items-center rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-purple-700 transition">
            Kalenderoverzicht
        </a>
        <a href="{{ route('admin.report') }}" class="inline-flex items-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-black transition">
            Rapportage
        </a>
        <a href="{{ route('admin.export.history') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 transition">
            Exporteer CSV
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Hardware</th>
                    <th class="px-6 py-3 font-semibold">Aantal</th>
                    <th class="px-6 py-3 font-semibold">Naam</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Aangevraagd op</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($loans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $item->hardware->name ?? 'Onbekend' }}</td>
                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                    <td class="px-6 py-4">{{ $item->borrower_name }}</td>
                    <td class="px-6 py-4">
                        @switch($item->status)
                        @case('approved') Goedgekeurd @break
                        @case('rejected') Afgewezen @break
                        @case('returned') Teruggebracht @break
                        @case('cancelled') Geannuleerd @break
                        @default In behandeling
                        @endswitch
                    </td>
                    <td class="px-6 py-4">{{ $item->created_at?->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>