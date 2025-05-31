<?php

namespace App\Http\Controllers;

use App\Models\TahapanPerkembangan;
use Illuminate\Http\Request;

class TahapanPerkembanganController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $tahapanPerkembangan = TahapanPerkembangan::all();
        return view('admin.tahapan_perkembangan.index', compact('tahapanPerkembangan'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.tahapan_perkembangan.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'nama_tahapan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'umur_minimal_bulan' => 'nullable|integer',
            'umur_maksimal_bulan' => 'nullable|integer',
        ]);

        
        TahapanPerkembangan::create([
            'nama_tahapan' => $request->nama_tahapan,
            'deskripsi' => $request->deskripsi,
            'umur_minimal_bulan' => $request->umur_minimal_bulan,
            'umur_maksimal_bulan' => $request->umur_maksimal_bulan,
        ]);

        return redirect()->route('admin.tahapan_perkembangan.index')->with('success', 'Tahapan Perkembangan berhasil ditambahkan');
    }

    public function edit(TahapanPerkembangan $tahapanPerkembangan)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.tahapan_perkembangan.edit', compact('tahapanPerkembangan'));
    }

    public function update(Request $request, TahapanPerkembangan $tahapanPerkembangan)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'nama_tahapan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'umur_minimal_bulan' => 'nullable|integer',
            'umur_maksimal_bulan' => 'nullable|integer',
        ]);

        $tahapanPerkembangan->update([
            'nama_tahapan' => $request->nama_tahapan,
            'deskripsi' => $request->deskripsi,
            'umur_minimal_bulan' => $request->umur_minimal_bulan,
            'umur_maksimal_bulan' => $request->umur_maksimal_bulan,
        ]);

        return redirect()->route('admin.tahapan_perkembangan.index')->with('success', 'Tahapan Perkembangan berhasil diupdate');
    }

    public function destroy(TahapanPerkembangan $tahapanPerkembangan)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $tahapanPerkembangan->delete();
        return back()->with('success', 'Tahapan Perkembangan berhasil dihapus');
    }
}