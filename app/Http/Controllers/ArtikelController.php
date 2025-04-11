<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Artikel;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::all();
        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $slug = Str::slug($request->title);

        // Cek apakah slug sudah ada
        $originalSlug = $slug;
        $counter = 1;
        while (\App\Models\Artikel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Artikel::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update($request->all());
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Artikel::destroy($id);
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->increment('views'); // ini langsung +1 views
        return view('admin.artikel.show', compact('artikel'));
    }


}
