<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index(Request $request)
    {
        $query = Hardware::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $hardwares = $query->latest()->get();

        return view('hardware.index', compact('hardwares'));
    }

    public function adminIndex(Request $request)
    {
        $query = Hardware::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $hardwares = $query->latest()->get();

        return view('admin.index', compact('hardwares'));
    }

    public function show(Hardware $hardware)
    {
        return view('hardware.show', compact('hardware'));
    }

    public function create()
    {
        return view('hardware.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,defective',
            'loan_duration_days' => 'required|integer|min:1|max:365',
        ]);

        Hardware::create($validated);

        return redirect()->route('admin.hardware.index')
            ->with('success', 'Hardware item succesvol toegevoegd.');
    }

    public function edit(Hardware $hardware)
    {
        return view('hardware.edit', compact('hardware'));
    }

    public function update(Request $request, Hardware $hardware)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,defective',
            'loan_duration_days' => 'required|integer|min:1|max:365',
        ]);

        $hardware->update($validated);

        return redirect()->route('admin.hardware.index')
            ->with('success', 'Hardware item succesvol bijgewerkt.');
    }

    public function destroy(Hardware $hardware)
    {
        $hardware->delete();

        return redirect()->route('admin.hardware.index')
            ->with('success', 'Hardware item verwijderd.');
    }
}
