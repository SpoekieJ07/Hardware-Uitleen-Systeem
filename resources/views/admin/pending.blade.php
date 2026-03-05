<x-app-layout>
    <h1>Pending uitleenverzoeken</h1>

    @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
    @endif

    @if($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Hardware</th>
            <th>Aantal</th>
            <th>Aanvrager</th>
            <th>Status</th>
            <th>Acties</th>
        </tr>

        @foreach($requests as $request)
        <tr>
            <td>{{ $request->id }}</td>
            <td>{{ $request->hardware->name ?? 'Onbekend' }}</td>
            <td>{{ $request->quantity }}</td>
            <td>{{ $request->borrower_name }}</td>
            <td>{{ $request->status }}</td>
            <td>
                <form method="POST" action="{{ route('admin.uitleen.approve', $request->id) }}">
                    @csrf
                    <button type="submit">Goedkeuren</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</x-app-layout>