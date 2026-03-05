<x-app-layout>

    <h1>Mijn uitleenaanvragen</h1>

    <div>
        <a href="{{ route('uitleen.create') }}"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
            + make new loan request
        </a>
    </div>

    <table border="1" cellpadding="6">
        <tr>
            <th>Hardware</th>
            <th>Aantal</th>
            <th>Naam</th>
            <th>Status</th>
            <th>Aangevraagd op</th>
        </tr>

        @foreach($uitleen as $item)
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
    </table>
</x-app-layout>