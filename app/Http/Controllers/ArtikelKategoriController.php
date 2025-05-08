<?php

namespace App\Http\Controllers;

use App\Models\ArtikelKategori;
use Illuminate\Http\Request;

class ArtikelKategoriController extends Controller
{
    public function index()
    {
        $kategoris = ArtikelKategori::all();
        return view('admin.artikel.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.artikel.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ArtikelKategori::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.artikel.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ArtikelKategori $kategori)
    {
        return view('admin.artikel.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, ArtikelKategori $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $kategori->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.artikel.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ArtikelKategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.artikel.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
