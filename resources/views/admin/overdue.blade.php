<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">
        Te laat ingeleverde items
    </h1>

    @if($overdueLoans->isEmpty())
    <p class="text-green-600">Geen te late items 🎉</p>
    @else
    <table class="w-full border mt-4">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Hardware</th>
                <th class="p-2">Gebruiker</th>
                <th class="p-2">Aantal</th>
                <th class="p-2">Inleverdatum</th>
                <th class="p-2">Te laat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overdueLoans as $loan)
            <tr class="border-t">
                <td class="p-2">{{ $loan->hardware->name }}</td>
                <td class="p-2">{{ $loan->borrower_name }}</td>
                <td class="p-2">{{ $loan->quantity }}</td>
                <td class="p-2">
                    {{ $loan->end_date->format('d-m-Y') }}
                </td>
                <td class="p-2 text-red-600 font-bold">
                    {{ $loan->end_date->diffInDays(now()) }} dagen
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</x-app-layout>