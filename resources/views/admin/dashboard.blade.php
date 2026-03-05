<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Dashboard</h1>
    <p class="text-gray-600">Welkom op je dashboard! Hier kun je een overzicht vinden van alle gebruiker uitleningen.</p>

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
                    @default In behandeling
                    @endswitch
                </td>
                <td>{{ $item->created_at?->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>