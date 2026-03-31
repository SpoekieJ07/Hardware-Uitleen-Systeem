<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pending uitleenverzoeken</h1>
        <div class="flex gap-4">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                Terug naar Dashboard
            </a>
            <a href="{{ route('admin.hardware.index') }}" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700 transition">
                Hardware Index
            </a>
        </div>
    </div>

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

                {{-- Goedkeuren --}}
                <form method="POST" action="{{ route('admin.pending.approve', $request->id) }}">
                    @csrf
                    <button type="submit">Goedkeuren</button>
                </form>

                <br>

                {{-- Afwijzen met reden --}}
                <form method="POST" action="{{ route('admin.pending.reject', $request->id) }}">
                    @csrf

                    <input
                        type="text"
                        name="review_notes"
                        placeholder="Reden van afwijzing"
                        required>

                    <button type="submit">Afwijzen</button>
                </form>

            </td>
        </tr>
        @endforeach

    </table>

</x-app-layout>