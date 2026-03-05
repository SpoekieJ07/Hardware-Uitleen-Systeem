<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Loan Requests (Admin)</h1>
            <p class="text-sm text-gray-500">Goedkeuren of afwijzen van aanvragen.</p>
        </div>

        @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div>
                <button class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                    Nieuwe Aanvraag
                </button>
            </div>
            <table class="min-w-full text-sm">
                <thead class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                    <tr>
                        <th class="px-5 py-3">Aanvrager</th>
                        <th class="px-5 py-3">Hardware</th>
                        <th class="px-5 py-3">Aantal</th>
                        <th class="px-5 py-3">Periode</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($requests as $r)
                    <tr>
                        <td class="px-5 py-4">{{ $r->user->name ?? '—' }}</td>
                        <td class="px-5 py-4 font-semibold">{{ $r->hardware->name ?? '—' }}</td>
                        <td class="px-5 py-4">{{ $r->quantity }}</td>
                        <td class="px-5 py-4">
                            {{ $r->start_at?->format('d-m-Y H:i') }} → {{ $r->due_at?->format('d-m-Y H:i') }}
                        </td>
                        <td class="px-5 py-4">{{ $r->status }}</td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                @if($r->status === 'pending')
                                <form method="POST" action="{{ route('admin.loan_requests.approve', $r) }}">
                                    @csrf
                                    <button class="rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700">
                                        Approve
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.loan_requests.reject', $r) }}">
                                    @csrf
                                    <input type="hidden" name="review_notes" value="Niet mogelijk / niet beschikbaar">
                                    <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">
                                        Reject
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-gray-500">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>