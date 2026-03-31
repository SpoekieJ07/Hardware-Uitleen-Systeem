<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Hardware Details</h2>
            <p class="text-sm text-gray-500">Overview of the selected item</p>
        </div>
        <a href="{{ route('hardware.index') }}" class="text-blue-600 hover:underline">&larr; Back to list</a>
    </div>

    <!-- Single hardware card/table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3 font-semibold">Name</th>
                    <th class="px-6 py-3 font-semibold">Total</th>
                    <th class="px-6 py-3 font-semibold">Price</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $hardware->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $hardware->total }}</td>
                    <td class="px-6 py-4 text-gray-700">€ {{ $hardware->price }}</td>
                    <td class="px-6 py-4 text-gray-700">
                        @if($hardware->status === 'defective')
                        <span class="text-red-600 font-semibold">Defect</span>
                        @else
                        <span class="text-green-600 font-semibold">Beschikbaar</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>