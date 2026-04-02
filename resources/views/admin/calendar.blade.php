<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kalenderoverzicht geplande uitleningen</h1>
            <p class="text-sm text-gray-500">Per item zie je welke uitleningen gepland staan.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
            Terug naar Dashboard
        </a>
    </div>

    @forelse($plannedLoans as $hardwareName => $loans)
    <div class="mb-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">{{ $hardwareName }}</h2>
        </div>

        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Gebruiker</th>
                    <th class="px-6 py-3 font-semibold">Aantal</th>
                    <th class="px-6 py-3 font-semibold">Startdatum</th>
                    <th class="px-6 py-3 font-semibold">Einddatum</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($loans as $loan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loan->borrower_name }}</td>
                    <td class="px-6 py-4">{{ $loan->quantity }}</td>
                    <td class="px-6 py-4">{{ $loan->start_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $loan->end_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">
                        @if($loan->status === 'approved')
                        <span class="text-green-600 font-semibold">Goedgekeurd</span>
                        @else
                        <span class="text-orange-600 font-semibold">Pending</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @empty
    <p class="text-green-600 font-medium">Er zijn momenteel geen geplande uitleningen.</p>
    @endforelse
</x-app-layout>