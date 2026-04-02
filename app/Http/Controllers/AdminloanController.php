<?php

namespace App\Http\Controllers;

use App\Mail\LoanApprovedMail;
use App\Mail\LoanRejectedMail;
use App\Models\Hardware;
use App\Models\Uitleen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            ->take(10)
            ->get();

        $stats = [
            'total_loans' => Uitleen::count(),
            'pending_count' => Uitleen::where('status', 'pending')->count(),
            'approved_count' => Uitleen::where('status', 'approved')->count(),
            'returned_count' => Uitleen::where('status', 'returned')->count(),
            'overdue_count' => Uitleen::where('status', 'approved')
                ->whereDate('end_date', '<', Carbon::today())
                ->count(),
            'defective_count' => Hardware::where('status', 'defective')->count(),
        ];

        return view('admin.dashboard', compact('loans', 'stats'));
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

    public function calendar()
    {
        $plannedLoans = Uitleen::with(['hardware', 'user'])
            ->whereIn('status', ['pending', 'approved'])
            ->whereDate('start_date', '>=', Carbon::today())
            ->orderBy('start_date')
            ->get()
            ->groupBy(fn($loan) => $loan->hardware->name ?? 'Onbekend item');

        return view('admin.calendar', compact('plannedLoans'));
    }

    public function report()
    {
        $totalLoans = Uitleen::count();
        $pendingCount = Uitleen::where('status', 'pending')->count();
        $approvedCount = Uitleen::where('status', 'approved')->count();
        $rejectedCount = Uitleen::where('status', 'rejected')->count();
        $returnedCount = Uitleen::where('status', 'returned')->count();
        $overdueCount = Uitleen::where('status', 'approved')
            ->whereDate('end_date', '<', Carbon::today())
            ->count();

        $topHardware = Uitleen::select('hardware_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('hardware')
            ->groupBy('hardware_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        $recentLoans = Uitleen::with(['hardware', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.report', compact(
            'totalLoans',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'returnedCount',
            'overdueCount',
            'topHardware',
            'recentLoans'
        ));
    }

    public function exportHistoryCsv(): StreamedResponse
    {
        $filename = 'uitleenhistorie_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM voor Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Hardware',
                'Gebruiker',
                'E-mail',
                'Aantal',
                'Status',
                'Startdatum',
                'Einddatum',
                'Aangevraagd op',
            ], ';');

            Uitleen::with(['hardware', 'user'])
                ->orderByDesc('created_at')
                ->chunk(200, function ($loans) use ($file) {
                    foreach ($loans as $loan) {
                        fputcsv($file, [
                            $loan->id,
                            $loan->hardware->name ?? 'Onbekend',
                            $loan->borrower_name,
                            $loan->user->email ?? '',
                            $loan->quantity,
                            $loan->status,
                            optional($loan->start_date)->format('d-m-Y'),
                            optional($loan->end_date)->format('d-m-Y'),
                            optional($loan->created_at)->format('d-m-Y H:i'),
                        ], ';');
                    }
                });

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
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

                if ((int) ($hardware->total ?? 0) < (int) $loanRequest->quantity) {
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
