<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    public function index()
    {
        $immunizations = Immunization::all();
        return view('admin.immunizations.index', compact('immunizations'));
    }

    public function create()
    {
        return view('admin.immunizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|string|max:100', 
            'description' => 'nullable|string', 
        ]);

        Immunization::create([
            'name' => $request->name,
            'age' => $request->age, 
            'description' => $request->description, 
        ]);

        return redirect()->route('admin.immunizations.index')->with('success', 'Imunisasi berhasil ditambahkan');
    }

    public function edit(Immunization $immunization)
    {
        return view('admin.immunizations.edit', compact('immunization'));
    }

    public function update(Request $request, Immunization $immunization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|string|max:100', 
            'description' => 'nullable|string', 
        ]);

        
        $immunization->update([
            'name' => $request->name,
            'age' => $request->age, 
            'description' => $request->description, 
        ]);

        return redirect()->route('admin.immunizations.index')->with('success', 'Imunisasi berhasil diupdate');
    }

    public function destroy(Immunization $immunization)
    {
        $immunization->delete();
        return back()->with('success', 'Imunisasi berhasil dihapus');
    }
}
