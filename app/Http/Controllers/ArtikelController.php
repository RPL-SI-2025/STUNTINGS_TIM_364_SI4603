<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\ArtikelKategori;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategoriIds = $request->input('kategori', []);
        $kategoris = ArtikelKategori::all();

        $artikels = Artikel::with('kategoris')
            ->when($kategoriIds, function ($query) use ($kategoriIds) {
                $query->whereHas('kategoris', function ($q) use ($kategoriIds) {
                    $q->whereIn('artikel_kategori_id', $kategoriIds);
                });
            })
            ->get();

        return view('admin.artikel.index', compact('artikels', 'kategoris', 'kategoriIds'));
    }

    public function create()
    {
        $kategoris = ArtikelKategori::all();
        return view('admin.artikel.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'kategori' => 'required|array',
            'kategori.*' => 'exists:artikel_kategoris,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Artikel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
        ];

        if ($request->hasFile('image')) {
            $path = $request->image->store('artikel-images', 'public');
            $data['image'] = $path;
        }

        $artikel = Artikel::create($data);
        $artikel->kategoris()->attach($request->kategori);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function show($id)
    {
        $artikel = Artikel::with('kategoris')->findOrFail($id);
        return view('admin.artikel.show', compact('artikel'));
    }

    public function edit($id)
    {
        $artikel = Artikel::with('kategoris')->findOrFail($id);
        $kategoris = ArtikelKategori::all();
        return view('admin.artikel.edit', compact('artikel', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'kategori' => 'required|array',
            'kategori.*' => 'exists:artikel_kategoris,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $artikel = Artikel::findOrFail($id);
        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            if ($artikel->image && Storage::exists('public/' . $artikel->image)) {
                Storage::delete('public/' . $artikel->image);
            }
            $path = $request->image->store('artikel-images', 'public');
            $data['image'] = $path;
        } else {
            $data['image'] = $artikel->image;
        }

        $artikel->update($data);
        $artikel->kategoris()->sync($request->kategori);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->image && Storage::exists('public/' . $artikel->image)) {
            Storage::delete('public/' . $artikel->image);
        }

        $artikel->kategoris()->detach();
        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
