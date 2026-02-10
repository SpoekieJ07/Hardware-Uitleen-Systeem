<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hardware;
use App\Http\Controllers\Controller;

class HardwareController extends Controller
{
    public function index()
    {
        return view('hardware.index', [
            'hardwares' => Hardware::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hardware.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'total' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Hardware::create($validated);

        return redirect()->route('hardware.index')->with('success', 'Hardware created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Hardware $hardware)
    {
            return view('hardware.edit', compact('hardware'));
    }

    public function update(Request $request, Hardware $hardware  )
    {
        $validated = $request->validate([
            'name' => 'required',
            'total' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $hardware->update($validated);

        return redirect()->route('hardware.index')->with('success', 'hardware updated successfully.');
    }

    public function destroy(Hardware $hardware)
    {
        $hardware->delete();
        return redirect()->route('hardware.index')->with('success', 'hardware deleted!');
    }
}