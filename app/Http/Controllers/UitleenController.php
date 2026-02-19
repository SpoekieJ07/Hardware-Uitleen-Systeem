<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use Illuminate\Http\Request;

class UitleenController extends Controller
{
    public function index()
    {
        $hardwares = Hardware::all();

        return view('uitleen.index', compact('hardwares'));
    }


    public function create()
    {
        return view('uitleen.create');
    }


    public function store(Request $request)
    {
        // Logic to store the lending information
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }



    public function destroy(string $id)
    {
        //
    }
}
