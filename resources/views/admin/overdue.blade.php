<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Te late items</h1>

        <div class="flex gap-4">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                Terug naar Dashboard
            </a>

            <a href="{{ route('admin.report') }}"
                class="inline-flex items-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-black transition">
                Rapportage
            </a>
        </div>
    </div>

    @if($overdueLoans->isEmpty())
    <p class="text-green-600 font-medium">Er zijn momenteel geen te late items.</p>
    @else
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Hardware</th>
                    <th class="px-6 py-3 font-semibold">Aantal</th>
                    <th class="px-6 py-3 font-semibold">Gebruiker</th>
                    <th class="px-6 py-3 font-semibold">Startdatum</th>
                    <th class="px-6 py-3 font-semibold">Inleverdatum</th>
                    <th class="px-6 py-3 font-semibold">Dagen te laat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($overdueLoans as $loan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loan->hardware->name ?? 'Onbekend' }}</td>
                    <td class="px-6 py-4">{{ $loan->quantity }}</td>
                    <td class="px-6 py-4">{{ $loan->borrower_name }}</td>
                    <td class="px-6 py-4">{{ $loan->start_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $loan->end_date?->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 text-red-600 font-semibold">
                        {{ $loan->end_date?->diffInDays(now()) }} dag(en)
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-app-layout>