<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <div class="flex items-end justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Mijn uitleenverzoeken</h1>
                <p class="text-sm text-gray-500">Status van je aanvragen.</p>
            </div>

            <a href="{{ route('loan_requests.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 shadow">
                + Nieuw verzoek
            </a>
        </div>

        @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                    <tr>
                        <th class="px-5 py-3">Hardware</th>
                        <th class="px-5 py-3">Aantal</th>
                        <th class="px-5 py-3">Periode</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($requests as $r)
                    <tr>
                        <td class="px-5 py-4 font-semibold text-gray-900">{{ $r->hardware->name ?? '—' }}</td>
                        <td class="px-5 py-4">{{ $r->quantity }}</td>
                        <td class="px-5 py-4">
                            {{ $r->start_at?->format('d-m-Y H:i') }} → {{ $r->due_at?->format('d-m-Y H:i') }}
                        </td>
                        <td class="px-5 py-4">
                            @php
                            $badge = match($r->status) {
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'cancelled' => 'bg-gray-100 text-gray-800',
                            default => 'bg-yellow-100 text-yellow-800',
                            };
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-500">
                            Je hebt nog geen verzoeken.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>