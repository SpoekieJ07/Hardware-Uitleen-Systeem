<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hardwearmodel;

class HardwearController extends Controller
{
    public function index()
    {
        return view('hardwear.index', [
            'hardwear' => Hardwearmodel::orderBy('naam')->get()
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

        Hardwearmodel::create($validated);

        return redirect()->route('hardwear.index')->with('success', 'Hardwear created successfully.');
    }
    public function show(string $id)
    {
        //
    }



    public function edit()
    {
     
    }
    public function update(Request $request, )
    {
        

    }

    public function destroy(Hardwearmodel $hardwear)
    {
        $hardwear->delete();
        return redirect()->route('hardwear.index')->with('success', 'Hardwear verwijderd!');
    }
}