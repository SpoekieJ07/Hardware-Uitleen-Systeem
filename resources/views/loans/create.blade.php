<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Uitleenverzoek indienen</h1>
            <p class="text-sm text-gray-500">Vraag hardware aan om te lenen.</p>
        </div>

        @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('loan_requests.store') }}" class="space-y-4 rounded-xl border bg-white p-6 shadow-sm">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Hardware</label>

                <select name="hardware_id" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @foreach($hardwares as $h)
                    <option value="{{ $h->id }}"
                        @selected(old('hardware_id', optional($hardware)->id) == $h->id)>
                        {{ $h->name }} (voorraad: {{ (int)($h->total ?? 0) }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Aantal</label>
                    <input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Start</label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at') }}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Inleveren (deadline)</label>
                <input type="datetime-local" name="due_at" value="{{ old('due_at') }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Reden / Opmerking (optioneel)</label>
                <textarea name="purpose" rows="4"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('purpose') }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('uitleen.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Annuleren
                </a>
                <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 shadow">
                    Verzoek indienen
                </button>
            </div>
        </form>
    </div>
</x-app-layout>