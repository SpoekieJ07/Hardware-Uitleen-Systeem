<x-app-layout>
    <form method="GET" action="{{ route('hardware.index') }}" class="mb-6 flex gap-4">
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
            href="{{ route('hardware.index') }}"
            class="rounded-lg bg-gray-500 px-4 py-2 text-white font-semibold hover:bg-gray-600 transition">
            Reset
        </a>
    </form>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Hardware List</h2>
            <p class="text-sm text-gray-500">Overview of all hardware items</p>
        </div>
    </div>

    <!-- Hardware tabel -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Name</th>
                    <th class="px-6 py-3 font-semibold">Total</th>
                    <th class="px-6 py-3 font-semibold">Price</th>
                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($hardware as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $item->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $item->total }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        € {{ $item->price }}
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        @if($item->status === 'defective')
                        <span class="text-red-600 font-semibold">Defect</span>
                        @else
                        <span class="text-green-600 font-semibold">Beschikbaar</span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">

                            <!-- Detail knop -->
                            <a href="{{ route('hardware.show', $item->id) }}"
                                class="rounded-lg bg-blue-500 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-600 transition">
                                Detail
                            </a>

                            <!-- Uitleen knop -->
                            <a href="{{ route ('uitleen.index')}}"
                                class="rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white hover:bg-red-600 transition">
                                Uitleenen
                            </a>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        no hardware found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>