<?php

namespace App\Http\Controllers;

use App\Models\Uitleen;
use Illuminate\Support\Facades\DB;

class AdminUitleenController extends Controller
{
    public function pending()
    {
        $requests = Uitleen::with('hardware')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.pending', compact('requests'));
    }

    public function approve(Uitleen $uitleen)
    {

        if ($uitleen->status !== 'pending') {
            return back()->withErrors('Dit verzoek is al beoordeeld.');
        }

        DB::transaction(function () use ($uitleen) {
            $uitleen = Uitleen::where('id', $uitleen->id)->lockForUpdate()->firstOrFail();
            $hardware = $uitleen->hardware()->lockForUpdate()->firstOrFail();


            if ($uitleen->quantity > $hardware->total) {
                abort(422, 'Niet genoeg voorraad om dit verzoek goed te keuren.');
            }

            $hardware->decrement('total', $uitleen->quantity);

            $uitleen->update([
                'status' => 'approved',
            ]);
        });

        return redirect()->route('admin.pending')
            ->with('success', 'Uitleenverzoek goedgekeurd.');
    }
}
