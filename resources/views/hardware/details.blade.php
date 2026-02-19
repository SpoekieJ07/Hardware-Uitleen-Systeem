
<x-app-layout>

    <div class="flex items-start justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Hardware details</h2>
            <p class="text-sm text-gray-500">Alle info over dit hardware item</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('hardware.edit', $hardware->id) }}"
                class="inline-flex items-center rounded-lg bg-yellow-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-yellow-600 transition">
                Edit
            </a>

            <a href="{{ route('hardware.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                ← Back
            </a>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">

            <div class="rounded-lg bg-gray-50 p-4">
                <dt class="text-gray-500">Name</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-800">{{ $hardware->name }}</dd>
            </div>

            <div class="rounded-lg bg-gray-50 p-4">
                <dt class="text-gray-500">Total</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-800">{{ $hardware->total }}</dd>
            </div>

            <div class="rounded-lg bg-gray-50 p-4">
                <dt class="text-gray-500">Price</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-800">
                    € {{ number_format($hardware->price, 2, ',', '.') }}
                </dd>
            </div>

            <div class="rounded-lg bg-gray-50 p-4">
                <dt class="text-gray-500">ID</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-800">#{{ $hardware->id }}</dd>
            </div>

            <div class="rounded-lg bg-gray-50 p-4">
                <dt class="text-gray-500">Created</dt>
                <dd class="mt-1 font-medium text-gray-800">{{ $hardware->created_at?->format('d-m-Y H:i') }}</dd>
            </div>

            <div class="rounded-lg bg-gray-50 p-4">
                <dt class="text-gray-500">Updated</dt>
                <dd class="mt-1 font-medium text-gray-800">{{ $hardware->updated_at?->format('d-m-Y H:i') }}</dd>
            </div>

        </dl>

        <div class="mt-6 flex items-center justify-between">

            <a href="{{ route('uitleen.index') }}"
                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                Naar uitleen overzicht
            </a>

            <form action="{{ route('hardware.destroy', $hardware->id) }}" method="POST"
                onsubmit="return confirm('Weet je zeker dat je dit hardware item wilt verwijderen?');">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-700 transition">
                    Delete
                </button>
            </form>

        </div>
    </div>

</x-app-layout>