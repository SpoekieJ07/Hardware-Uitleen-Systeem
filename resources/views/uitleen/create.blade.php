<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Uitleenverzoek indienen</h1>
            <p class="text-sm text-gray-500">
                Kies een hardware item en vul je aanvraaggegevens in.
            </p>
        </div>

        @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('uitleen.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="hardware_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Hardware item
                    </label>
                    <select
                        name="hardware_id"
                        id="hardware_id"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Kies een item --</option>
                        @foreach($hardware as $item)
                        <option value="{{ $item->id }}" {{ old('hardware_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} ({{ $item->total }} beschikbaar)
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                        Aantal
                    </label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        min="1"
                        value="{{ old('quantity') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Startdatum
                    </label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ old('start_date') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                    <p class="mt-2 text-sm text-gray-500">
                        De einddatum wordt automatisch berekend op basis van de ingestelde uitleentermijn van het item.
                    </p>
                </div>

                <div>
                    <label for="borrower_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Naam
                    </label>
                    <input
                        type="text"
                        name="borrower_name"
                        id="borrower_name"
                        value="{{ old('borrower_name', auth()->user()->name ?? '') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                        Verzoek indienen
                    </button>

                    <a
                        href="{{ route('hardware.index') }}"
                        class="rounded-lg bg-gray-500 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-600 transition">
                        Annuleren
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>