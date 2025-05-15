<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\ArtikelKategori;

class UserArtikelController extends Controller
{
    // Tampilkan daftar semua artikel untuk user
    public function index(Request $request)
    {
        $kategoriIds = $request->input('kategori', []);
        $kategoris = ArtikelKategori::all();

        if (!empty($kategoriIds)) {
            $artikels = Artikel::whereHas('kategoris', function ($query) use ($kategoriIds) {
                $query->whereIn('artikel_kategori_id', $kategoriIds);
            })->get();
        } else {
            $artikels = Artikel::all();
        }

        return view('orangtua.artikel.index', compact('artikels', 'kategoris', 'kategoriIds'));
    }


    // Tampilkan detail satu artikel
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Tambah 1 view setiap kali artikel dibuka oleh user
        $artikel->increment('views');

}
}