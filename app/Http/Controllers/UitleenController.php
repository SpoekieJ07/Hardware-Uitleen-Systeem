<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uitleen;
use App\Http\Controllers\Controller;

class UitleenController extends Controller
{
    public function index()
    {
        return view('uitleen.index', [
            'uitleen' => Uitleen::all()
        ]);
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
