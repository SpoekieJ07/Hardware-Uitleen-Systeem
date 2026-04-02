<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Uitleenhistorie</h1>
            <p class="text-sm text-gray-500">Overzicht van al je eerdere en huidige uitleenaanvragen.</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('uitleen.index') }}"
                class="rounded-lg bg-gray-500 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-600 transition">
                Terug naar aanvragen
            </a>

            <a href="{{ route('uitleen.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                + Nieuwe aanvraag
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Hardware</th>
                    <th class="px-6 py-3 font-semibold">Aantal</th>
                    <th class="px-6 py-3 font-semibold">Naam</th>
                    <th class="px-6 py-3 font-semibold">Start</th>
                    <th class="px-6 py-3 font-semibold">Eind</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Aangevraagd op</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($history as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $item->hardware->name ?? 'Onbekend' }}</td>
                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                    <td class="px-6 py-4">{{ $item->borrower_name }}</td>
                    <td class="px-6 py-4">{{ $item->start_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $item->end_date?->format('d-m-Y') }}</td>

                    <td class="px-6 py-4">
                        @switch($item->status)
                        @case('approved')
                        <span class="font-semibold text-green-600">Goedgekeurd</span>
                        @break

                        @case('rejected')
                        <span class="font-semibold text-red-600">Afgewezen</span>
                        @if($item->review_notes)
                        <div class="mt-1 text-xs text-gray-600">
                            <strong>Reden:</strong> {{ $item->review_notes }}
                        </div>
                        @endif
                        @break

                        @case('returned')
                        <span class="font-semibold text-blue-600">Teruggebracht</span>
                        @break

                        @case('cancelled')
                        <span class="font-semibold text-gray-500">Geannuleerd</span>
                        @break

                        @default
                        <span class="font-semibold text-orange-600">In behandeling</span>
                        @endswitch
                    </td>

                    <td class="px-6 py-4">{{ $item->created_at?->format('d-m-Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                        Er is nog geen uitleenhistorie beschikbaar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>