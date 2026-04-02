<x-app-layout>
    <form method="GET" action="{{ route('admin.hardware.index') }}" class="mb-6 flex flex-wrap gap-4">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Zoek op naam..."
            class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

        <select
            name="status"
            class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Alle statussen</option>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>
                Beschikbaar
            </option>
            <option value="defective" {{ request('status') === 'defective' ? 'selected' : '' }}>
                Defect
            </option>
        </select>

        <button
            type="submit"
            class="rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition">
            Filter
        </button>

        <a
            href="{{ route('admin.hardware.index') }}"
            class="rounded-lg bg-gray-500 px-4 py-2 text-white font-semibold hover:bg-gray-600 transition">
            Reset
        </a>
    </form>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Hardware Overzicht</h2>
            <p class="text-sm text-gray-500">Beheer al je hardware items</p>
        </div>

        <a href="{{ route('hardware.create') }}"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
            + Maak nieuwe hardware
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Name</th>
                    <th class="px-6 py-3 font-semibold">Total</th>
                    <th class="px-6 py-3 font-semibold">Price</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Loanduur</th>
                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($hardwares as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $item->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $item->total }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        € {{ number_format($item->price, 2, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        @if($item->status === 'defective')
                        <span class="text-red-600 font-semibold">Defect</span>
                        @else
                        <span class="text-green-600 font-semibold">Beschikbaar</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $item->loan_duration_days ?? '-' }} dagen
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('hardware.edit', $item->id) }}"
                                class="rounded-lg bg-yellow-500 px-3 py-2 text-xs font-semibold text-white hover:bg-yellow-600 transition">
                                Edit
                            </a>

                            <a href="{{ route('hardware.show', $item->id) }}"
                                class="rounded-lg bg-blue-500 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-600 transition">
                                Detail
                            </a>

                            <form action="{{ route('hardware.destroy', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this hardware item?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        Geen hardware gevonden.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>