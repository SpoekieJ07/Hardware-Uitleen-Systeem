<?php

namespace App\Http\Controllers;

use App\Models\Uitleen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\LoanApprovedMail;
use App\Mail\LoanRejectedMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdminloanController extends Controller
{
    public function index()
    {
        $requests = Uitleen::with(['hardware', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.pending', compact('requests'));
    }

    public function dashboard()
    {
        $loans = Uitleen::with(['hardware', 'user'])
            ->latest()
            ->get();

        $overdueCount = Uitleen::where('status', 'approved')
            ->whereDate('end_date', '<', Carbon::today())
            ->count();

        return view('admin.dashboard', compact('loans', 'overdueCount'));
    }

    public function overdue()
    {
        $overdueLoans = Uitleen::with(['hardware', 'user'])
            ->where('status', 'approved')
            ->whereDate('end_date', '<', Carbon::today())
            ->orderBy('end_date', 'asc')
            ->get();

        return view('admin.overdue', compact('overdueLoans'));
    }

    public function approve(Uitleen $loanRequest)
    {
        try {
            DB::transaction(function () use ($loanRequest) {
                $loanRequest->refresh();

                if ($loanRequest->status !== 'pending') {
                    return;
                }

                $loanRequest->load(['hardware', 'user']);

                $hardware = $loanRequest->hardware()->lockForUpdate()->first();

                if ((int)($hardware->total ?? 0) < (int)$loanRequest->quantity) {
                    throw new \Exception('Onvoldoende voorraad voor dit verzoek.');
                }

                $hardware->decrement('total', $loanRequest->quantity);

                $loanRequest->update([
                    'status' => 'approved',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                ]);
            });

            $loanRequest->load(['hardware', 'user']);

            if ($loanRequest->user && $loanRequest->user->email) {
                Mail::to($loanRequest->user->email)->send(new LoanApprovedMail($loanRequest));
            }
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Verzoek goedgekeurd en e-mail verstuurd.');
    }

    public function reject(Request $request, Uitleen $loanRequest)
    {
        $data = $request->validate([
            'review_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($loanRequest->status !== 'pending') {
            return back()->with('error', 'Dit verzoek is al verwerkt.');
        }

        $loanRequest->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $data['review_notes'] ?? null,
        ]);

        $loanRequest->load(['hardware', 'user']);

        if ($loanRequest->user && $loanRequest->user->email) {
            Mail::to($loanRequest->user->email)->send(new LoanRejectedMail($loanRequest));
        }

        return back()->with('success', 'Verzoek afgewezen en e-mail verstuurd.');
    }
}
