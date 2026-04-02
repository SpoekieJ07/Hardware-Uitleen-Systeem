<x-app-layout>
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $hardware->name }}
            </h1>

            <a href="{{ route('hardware.index') }}"
                class="rounded-lg bg-gray-500 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-600 transition">
                Terug
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">

            <div>
                <span class="font-semibold text-gray-700">Naam:</span>
                <span class="text-gray-800">{{ $hardware->name }}</span>
            </div>

            <div>
                <span class="font-semibold text-gray-700">Aantal beschikbaar:</span>
                <span class="text-gray-800">{{ $hardware->total }}</span>
            </div>

            <div>
                <span class="font-semibold text-gray-700">Prijs:</span>
                <span class="text-gray-800">€ {{ number_format($hardware->price, 2, ',', '.') }}</span>
            </div>

            <div>
                <span class="font-semibold text-gray-700">Status:</span>
                @if($hardware->status === 'defective')
                <span class="text-red-600 font-semibold">Defect</span>
                @else
                <span class="text-green-600 font-semibold">Beschikbaar</span>
                @endif
            </div>

            <div>
                <span class="font-semibold text-gray-700">Uitleentermijn:</span>
                <span class="text-gray-800">{{ $hardware->loan_duration_days }} dagen</span>
            </div>

        </div>

        <div class="mt-6 flex gap-3">
            @if($hardware->status === 'available' && $hardware->total > 0)
            <a href="{{ route('uitleen.create', ['hardware_id' => $hardware->id]) }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                Aanvragen
            </a>
            @endif
        </div>

    </div>
</x-app-layout>