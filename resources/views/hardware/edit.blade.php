<x-app-layout>

    <div class="max-w-xl mx-auto">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Hardware edit
        </h2>

        <div class="bg-white shadow-md rounded-xl p-8">

            <form action="{{ route('hardware.update', $hardware->id) }}"
                method="POST"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Naam
                    </label>
                    <input type="text"
                        name="name"
                        id="name"
                        value="{{ $hardware->name }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Total -->
                <div>
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-1">
                        Total
                    </label>
                    <input type="number"
                        name="total"
                        id="total"
                        value="{{ $hardware->total }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                        price
                    </label>
                    <input type="number"
                        step="0.01"
                        name="price"
                        id="price"
                        value="{{ $hardware->price }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-4">

                    <a href="{{ route('hardware.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-800">
                        ← back to hardware list
                    </a>

                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-yellow-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-yellow-600 transition">
                        Update Hardware
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>