<?php

namespace App\Http\Controllers;

use App\Models\TahapanPerkembangan;
use Illuminate\Http\Request;

class TahapanPerkembanganController extends Controller
{
    public function index()
    {
        $tahapanPerkembangan = tahapanPerkembangan::all();
        return view('adminTahapan.index', compact('tahapanPerkembangan'));
    }

    public function create()
    {
        return view('adminTahapan.create');
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