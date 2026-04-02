<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Dashboard</h1>
    <p class="text-gray-600">Welkom op je dashboard! Hier kun je een overzicht vinden van alle gebruiker uitleningen.</p>

    <p class="text-red-600 font-semibold mt-2">
        Te late items: {{ $overdueCount }}
    </p>

    <div class="mt-6 mb-6 flex gap-4">
        <a href="{{ route('admin.pending') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
            Bekijk pending uitleenverzoeken
        </a>
        <a href="{{ route('admin.hardware.index') }}" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700 transition">
            Hardware Index
        </a>
        <a href="{{ route('admin.overdue') }}" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-700 transition">
            Bekijk te late items
        </a>
    </div>

    <table border="1" cellpadding="6" class="mt-4 w-full">
        <thead>
            <tr class="bg-gray-200">
                <th>Hardware</th>
                <th>Aantal</th>
                <th>Naam</th>
                <th>Status</th>
                <th>Aangevraagd op</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $item)
            <tr>
                <td>{{ $item->hardware->name ?? 'Onbekend' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->borrower_name }}</td>
                <td>
                    @switch($item->status)
                    @case('approved') Goedgekeurd @break
                    @case('rejected') Afgewezen @break
                    @case('returned') Teruggebracht @break
                    @case('cancelled') Geannuleerd @break
                    @default In behandeling
                    @endswitch
                </td>
                <td>{{ $item->created_at?->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>