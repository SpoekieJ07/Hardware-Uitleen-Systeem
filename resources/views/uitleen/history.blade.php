<x-app-layout>

    <h1>Uitleenhistorie</h1>

    <table border="1" cellpadding="6">
        <tr>
            <th>Hardware</th>
            <th>Aantal</th>
            <th>Naam</th>
            <th>Start</th>
            <th>Eind</th>
            <th>Status</th>
            <th>Aangevraagd op</th>
        </tr>

        @foreach($history as $item)
        <tr>
            <td>{{ $item->hardware->name ?? 'Onbekend' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->borrower_name }}</td>
            <td>{{ $item->start_date }}</td>
            <td>{{ $item->end_date }}</td>

            {{-- Status + reden (als rejected) --}}
            <td>
                {{ $item->status }}

                @if($item->status === 'rejected' && $item->review_notes)
                <br>
                <small><strong>Reden:</strong> {{ $item->review_notes }}</small>
                @endif
            </td>

            <td>{{ $item->created_at?->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </table>

</x-app-layout>