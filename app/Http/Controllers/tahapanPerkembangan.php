<?php

namespace App\Http\Controllers;

use App\Models\tahapanPerkembangan;
use Illuminate\Http\Request;

class tahapanPerkembanganController extends Controller
{
    public function index()
    {
        $tahapanPerkembangan = tahapanPerkembangan::all();
        return view('admin.tahapanPerkembangan.index', compact('tahapanPerkembangan'));
    }

    public function create()
    {
        return view('admin.tahapanPerkembangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'tahapan' => 'required',
            'deskripsi' => 'required',
        ]);

        tahapanPerkembangan::create($request->all());

        return redirect()->route('admin.tahapanPerkembangan.index')->with('success', 'Data berhasil ditambahkan');
    }
}