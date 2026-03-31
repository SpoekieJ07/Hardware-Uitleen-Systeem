<x-app-layout>

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
                @forelse ($hardwares as $item)
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