<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hardwhearmodel;

class HardwhearController extends Controller
{
    public function index()
    {
        return view('hardwhear.index', [
            'hardwhears' => Hardwhearmodel::orderBy('naam')->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hardwear.create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required',
            'aantal' => 'required|integer',
            'prijs' => 'required|numeric',
        ]);

        Hardwhearmodel::create($validated);

        return redirect()->route('hardwhear.index')->with('success', 'Hardwhear created successfully.');
    }
    public function show(string $id)
    {
        //
    }



    public function edit(Hardwhearmodel $hardwhear)
    {
            return view('hardwhear.edit', compact('hardwhear'));
    }
    public function update(Request $request, Hardwhearmodel $hardwhear  )
    {
        $validated = $request->validate([
            'naam' => 'required',
            'aantal' => 'required|integer',
            'prijs' => 'required|numeric',
        ]);

        $hardwhear->update($validated);

        return redirect()->route('hardwhear.index')->with('success', 'Hardwhear updated successfully.');
    }

    public function destroy(Hardwhearmodel $hardwear)
    {
        $hardwear->delete();
        return redirect()->route('hardwhear.index')->with('success', 'Hardwhear verwijderd!');
    }
}