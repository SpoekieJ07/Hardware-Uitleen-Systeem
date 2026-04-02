<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Mijn uitleenaanvragen</h1>
            <p class="text-sm text-gray-500">Overzicht van jouw aanvragen en statussen.</p>
        </div>

        <a href="{{ route('uitleen.create') }}"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
            + Nieuwe aanvraag
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Hardware</th>
                    <th class="px-6 py-3 font-semibold">Aantal</th>
                    <th class="px-6 py-3 font-semibold">Naam</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Startdatum</th>
                    <th class="px-6 py-3 font-semibold">Einddatum</th>
                    <th class="px-6 py-3 font-semibold">Aangevraagd op</th>
                    <th class="px-6 py-3 font-semibold text-right">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($uitleen as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $item->hardware->name ?? 'Onbekend' }}</td>
                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                    <td class="px-6 py-4">{{ $item->borrower_name }}</td>

                    <td class="px-6 py-4">
                        @switch($item->status)
                        @case('approved')
                        <span class="font-semibold text-green-600">Goedgekeurd</span>
                        @break

                        @case('rejected')
                        <span class="font-semibold text-red-600">Afgewezen</span>
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

                    <td class="px-6 py-4">{{ $item->start_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $item->end_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $item->created_at?->format('d-m-Y H:i') }}</td>

                    <td class="px-6 py-4">
                        <div class="flex justify-end">
                            @if($item->status === 'pending')
                            <form action="{{ route('uitleen.destroy', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Weet je zeker dat je dit verzoek wilt annuleren?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white hover:bg-red-600 transition">
                                    Annuleren
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">Geen actie mogelijk</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                        Je hebt nog geen uitleenaanvragen.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>