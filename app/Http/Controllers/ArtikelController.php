<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;

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

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);

        return view('admin.artikel.show', compact('artikel'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk gambar
        ]);

        $slug = Str::slug($request->title);

        // Cek apakah slug sudah ada
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

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->image->store('artikel-images', 'public');  // Menyimpan gambar di folder public/artikel-images
            $data['image'] = $path; // Simpan path gambar ke database
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $artikel = Artikel::findOrFail($id);
        $data = $request->only(['title', 'content']);

        // Jika user upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama (jika ada dan file-nya masih ada di storage)
            if ($artikel->image && Storage::exists($artikel->image)) {
                Storage::delete($artikel->image);
            }
            
            $path = $request->image->store('artikel-images', 'public');
            $data['image'] = $path;
            
        } else {
            // Tidak upload gambar baru, gunakan gambar lama
            $data['image'] = $artikel->image;
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }



    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Hapus gambar dari storage kalau ada
        if ($artikel->image && Storage::exists('public/' . $artikel->image)) {
            Storage::delete('public/' . $artikel->image);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }

}
