<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Uitleen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UitleenController extends Controller
{
    public function index()
    {
        $uitleen = Uitleen::with('hardware')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('uitleen.index', compact('uitleen'));
    }

    public function create()
    {
        $hardware = Hardware::where('status', 'available')->get();
        return view('uitleen.create', compact('hardware'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hardware_id' => 'required|exists:hardware,id',
            'quantity' => 'required|integer|min:1',
            'borrower_name' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        $hardware = Hardware::findOrFail($request->hardware_id);

        if ($hardware->status === 'defective') {
            return back()->withErrors('Dit item is defect en kan niet worden uitgeleend.');
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($hardware->loan_duration_days);

        Uitleen::create([
            'user_id' => Auth::id(),
            'hardware_id' => $request->hardware_id,
            'quantity' => $request->quantity,
            'borrower_name' => $request->borrower_name,
            'status' => 'pending',
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        return redirect()->route('uitleen.index')
            ->with('success', 'Uitleenverzoek ingediend!');
    }

    public function history()
    {
        $history = Uitleen::with('hardware')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('uitleen.history', compact('history'));
    }

    public function destroy(Uitleen $uitleen)
    {
        if ($uitleen->user_id !== Auth::id()) {
            abort(403);
        }

        if ($uitleen->status !== 'pending') {
            return redirect()->route('uitleen.index')
                ->with('error', 'Alleen pending verzoeken kunnen verwijderd worden.');
        }

        $uitleen->delete();

        return redirect()->route('uitleen.index')
            ->with('success', 'Uitleenverzoek verwijderd.');
    }
}
