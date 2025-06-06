@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e5e7eb;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 2rem auto;
        background-color: #f3f4f6;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    h1 {
        color: #005f77;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-top: 1rem;
        font-weight: 600;
        color: #374151;
    }

    input[type="text"],
    input[type="file"],
    textarea,
    select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        font-size: 1rem;
        background-color: #fff;
    }

    select[multiple] {
        height: auto;
    }

    button {
        margin-top: 1.5rem;
        padding: 0.75rem 1.5rem;
        background-color: #005f77;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #014f66;
    }

    .back-link {
        display: inline-block;
        margin-top: 1rem;
        text-decoration: none;
        color: #374151;
        font-size: 0.9rem;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    img {
        max-width: 200px;
        margin-top: 0.5rem;
        border-radius: 0.5rem;
    }
</style>

<div class="container">
    <h1>Edit Artikel</h1>

    <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="title">Judul Artikel</label>
        <input type="text" name="title" id="title" value="{{ old('title', $artikel->title) }}" required>

        <label for="content">Konten</label>
        <textarea name="content" id="content" rows="10" required>{{ old('content', $artikel->content) }}</textarea>

        <label for="image">Gambar (opsional)</label>
        <input type="file" name="image" id="image" accept="image/*">

        @if ($artikel->image)
            <p>Gambar saat ini:</p>
            <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Artikel">
        @endif

        <label for="kategori">Pilih Kategori</label>
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
            @foreach ($kategoris as $kategori)
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem;">
                    <input type="checkbox" name="kategori[]" value="{{ $kategori->id }}"
                        {{ in_array($kategori->id, $selectedKategori ?? []) ? 'checked' : '' }}>
                    {{ $kategori->name }}
                </label>
            @endforeach
        </div>


        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="{{ route('admin.artikel.index') }}" class="back-link">← Kembali ke daftar artikel</a>
</div>
@endsection
