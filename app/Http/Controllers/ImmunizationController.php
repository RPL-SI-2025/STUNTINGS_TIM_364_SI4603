<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = Immunization::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $immunizations = $query->get();

        return view('admin.immunizations.index', compact('immunizations'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('admin.immunizations.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if (!$immunization) {
            return redirect()->route('admin.immunizations.index')->with('error', 'Imunisasi tidak ditemukan.');
        }

        return view('admin.immunizations.edit', compact('immunization'));
    }

    public function update(Request $request, Immunization $immunization)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $immunization->delete();
        return back()->with('success', 'Imunisasi berhasil dihapus');
    }
}
