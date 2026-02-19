<?php

namespace App\Http\Controllers;


use App\Models\Hardware;
use App\Models\LoanRequest;
use Illuminate\Http\Request;

class LoanRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'hardware_id' => ['required', 'exists:hardware,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'start_at' => ['required', 'date', 'after_or_equal:now'],
            'due_at' => ['required', 'date', 'after:start_at'],
            'purpose' => ['nullable', 'string', 'max:2000'],
        ]);

        $hardware = Hardware::findOrFail($data['hardware_id']);

        // Simpele beschikbaarheidscheck (bij goedkeuring check je opnieuw)
        if (($hardware->total ?? 0) < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Niet genoeg voorraad beschikbaar.'])->withInput();
        }

        LoanRequest::create([
            ...$data,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('loan_requests.my')->with('success', 'Uitleenverzoek ingediend.');
    }
}
