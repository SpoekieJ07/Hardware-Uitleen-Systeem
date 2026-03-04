<h1>Uitleenverzoeken</h1>

<a href="{{ route('uitleen.create') }}">Nieuw verzoek</a>

<table border="1">
<tr>
    <th>Hardware</th>
    <th>Aantal</th>
    <th>Naam</th>
</tr>

@foreach($uitleen as $item)
<tr>
    <td>{{ $item->hardware->name }}</td>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->borrower_name }}</td>
</tr>
@endforeach

</table>