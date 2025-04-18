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
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        font-size: 1rem;
        background-color: #fff;
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
</style>

<div class="container">
    <h1>Buat Artikel Baru</h1>

    <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="title">Judul Artikel</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required>

        <label for="content">Konten</label>
        <textarea name="content" id="content" rows="10" required>{{ old('content') }}</textarea>

        <label for="image">Gambar (opsional)</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Publikasikan</button>
    </form>

    <a href="{{ route('admin.artikel.index') }}" class="back-link">← Kembali ke daftar artikel</a>
</div>
@endsection
