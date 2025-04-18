<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;

class UserArtikelController extends Controller
{
    // Tampilkan daftar semua artikel untuk user
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('user.artikel.index', compact('artikels'));
    }

    // Tampilkan detail satu artikel
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Tambah 1 view setiap kali artikel dibuka oleh user
        $artikel->increment('views');

        return view('user.artikel.show', compact('artikel'));
    }

}
