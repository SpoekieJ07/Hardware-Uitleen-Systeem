<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoanRequestController extends Controller
{
    public function index()
    {
        $requests = LoanRequest::with(['hardware', 'user'])
            ->latest()
            ->get();

        return view('admin.loan_requests.index', compact('requests'));
    }

    public function approve(LoanRequest $loanRequest)
    {
        try {
            DB::transaction(function () use ($loanRequest) {
                $loanRequest->refresh();

                if ($loanRequest->status !== 'pending') {
                    return;
                }

                $loanRequest->load('hardware');

                // lock hardware row (voorkomt race conditions)
                $hardware = $loanRequest->hardware()->lockForUpdate()->first();

                if ((int)($hardware->total ?? 0) < (int)$loanRequest->quantity) {
                    throw new \Exception('Onvoldoende voorraad voor dit verzoek.');
                }

                $hardware->decrement('total', $loanRequest->quantity);

                $loanRequest->update([
                    'status' => 'approved',
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                ]);
            });
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Verzoek goedgekeurd.');
    }

    public function reject(Request $request, LoanRequest $loanRequest)
    {
        $data = $request->validate([
            'review_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($loanRequest->status !== 'pending') {
            return back()->with('error', 'Dit verzoek is al verwerkt.');
        }

        $loanRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $data['review_notes'] ?? null,
        ]);

        return back()->with('success', 'Verzoek afgewezen.');
    }
}
