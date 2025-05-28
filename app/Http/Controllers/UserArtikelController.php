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
        $search = $request->input('search');
        $kategoris = ArtikelKategori::all();

        $artikels = Artikel::query();

        if (!empty($kategoriIds)) {
            $artikels->whereHas('kategoris', function ($query) use ($kategoriIds) {
                $query->whereIn('artikel_kategori_id', $kategoriIds);
            });
        }

        if (!empty($search)) {
            $artikels->where('title', 'like', '%' . $search . '%');
        }

        return view('orangtua.artikel.index', [
            'artikels' => $artikels->latest()->paginate(12)->appends($request->query()),
            'kategoris' => $kategoris,
            'kategoriIds' => $kategoriIds,
        ]);
    }



    // Tampilkan detail satu artikel
    public function show($id)
    {
        $artikel = Artikel::with('kategoris')->findOrFail($id);
        return view('orangtua.artikel.show', compact('artikel'));

        // Tambah 1 view setiap kali artikel dibuka oleh user
        $artikel->increment('views');

}
}