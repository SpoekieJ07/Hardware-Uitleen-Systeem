<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hardware;
use App\Models\Uitleen;
use Illuminate\Support\Facades\Auth;

class UitleenController extends Controller
{
    public function index()
    {
        $uitleen = Uitleen::with('hardware')->latest()->get();
        return view('uitleen.index', compact('uitleen'));
    }

    public function create()
    {
        $hardware = Hardware::all();
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

        if ($request->quantity > $hardware->total) {
            return back()->withErrors('Niet genoeg voorraad beschikbaar.');
        }

        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($hardware->loan_duration_days);

        Uitleen::create([
            'user_id' => Auth::id(),
            'hardware_id' => $request->hardware_id,
            'quantity' => $request->quantity,
            'borrower_name' => $request->borrower_name,
            'status' => 'pending',
            'start_date' => $request->start_date,
            'end_date' => $endDate->toDateString(),
        ]);

        $hardware->decrement('total', $request->quantity);

        return redirect()->route('uitleen.index')
            ->with('success', 'Uitleenverzoek ingediend!');
    }
    public function history()
    {

        $history = Uitleen::with('hardware')
            ->orderByDesc('created_at')
            ->get();

        return view('uitleen.history', compact('history'));
    }
    public function destroy(Uitleen $uitleen)
    {
        $uitleen->delete();

        return redirect()->route('uitleen.index')
            ->with('success', 'Uitleenverzoek verwijderd.');
    }
}
