    <x-app-layout>
        <h1>Uitleenverzoek indienen</h1>

        <form method="POST" action="{{ route('uitleen.store') }}">
            @csrf

            <label>Hardware item:</label>
            <select name="hardware_id" required>
                @foreach($hardware as $item)
                <option value="{{ $item->id }}">
                    {{ $item->name }} ({{ $item->total }} beschikbaar)
                </option>
                @endforeach
            </select>

            <br><br>

            <label>Aantal:</label>
            <input type="number" name="quantity" min="1" required>
            <br><br>

            <label>Startdatum:</label>
            <input type="date" name="start_date" required>

            <br><br>

            <label>Einddatum:</label>
            <input type="date" name="end_date" required>

            <br><br>

            <label>Naam:</label>
            <input type="text" name="borrower_name" required>

            <br><br>

            <button type="submit">Verzoek indienen</button>

        </form>

    </x-app-layout>