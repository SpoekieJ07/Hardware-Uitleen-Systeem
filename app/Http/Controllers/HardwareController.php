<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hardware;
use App\Http\Controllers\Controller;

class HardwareController extends Controller
{
    public function index()
    {
        $hardwares = Hardware::all();
        return view('hardware.index', compact('hardwares'));
    }

    public function adminIndex()
    {
        $hardwares = Hardware::all();
        return view('admin.index', compact('hardwares'));
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
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'total' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Hardware::create($validated);

        return redirect()->route('hardware.index')->with('success', 'Hardware created successfully.');
    }

    public function show(Hardware $hardware)
    {
        // display single hardware item in the detail view
        return view('hardware.detail', compact('hardware'));
    }

    public function edit(Hardware $hardware)
    {
        return view('hardware.edit', compact('hardware'));
    }

    public function update(Request $request, Hardware $hardware)
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
