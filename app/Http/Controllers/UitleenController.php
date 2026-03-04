<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hardware;
use App\Models\Uitleen;

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
        ]);

        $hardware = Hardware::findOrFail($request->hardware_id);

        if ($request->quantity > $hardware->total) {
            return back()->withErrors('Niet genoeg voorraad beschikbaar.');
        }

        Uitleen::create([
            'hardware_id' => $request->hardware_id,
            'quantity' => $request->quantity,
            'borrower_name' => $request->borrower_name,
        ]);

        $hardware->decrement('total', $request->quantity);

        return redirect()->route('uitleen.index')
            ->with('success', 'Uitleenverzoek ingediend!');
    }
}
