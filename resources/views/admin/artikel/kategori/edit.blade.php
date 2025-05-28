@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e5e7eb;
    }

    .form-wrapper {
        max-width: 600px;
        margin: 2rem auto;
        background-color: #f3f4f6;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .form-title {
        color: #005f77;
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    input[type="text"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1rem;
        margin-bottom: 1.5rem;
        background-color: #ffffff;
    }

    .btn-submit {
        display: inline-block;
        background-color: #005f77;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #014f66;
    }

    .back-link {
        display: inline-block;
        margin-top: 1.5rem;
        text-decoration: none;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="form-wrapper">
    <h1 class="form-title">Edit Kategori Artikel</h1>

    <form action="{{ route('admin.artikel.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nama Kategori</label>
        <input type="text" name="name" id="name" value="{{ $kategori->name }}" required>

        <button type="submit" class="btn-submit">Update</button>
    </form>

    <a href="{{ route('admin.artikel.kategori.index') }}" class="back-link">← Kembali ke daftar kategori</a>
</div>
@endsection
