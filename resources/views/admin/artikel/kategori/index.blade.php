@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e5e7eb;
        margin: 0;
        padding: 0;
    }

    .main-title {
        text-align: center;
        color: #005f77;
        font-size: 2rem;
        margin: 2rem 0;
    }

    .table-container {
        max-width: 900px;
        margin: 0 auto 2rem auto;
        background-color: #f3f4f6;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .action-btns {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.5rem 0.75rem;
        background-color: #005f77;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #014f66;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th, td {
        padding: 0.75rem;
        border-bottom: 1px solid #d1d5db;
        text-align: left;
    }

    th {
        background-color: #e0f2f1;
        color: #005f77;
    }

    .add-button {
        display: block;
        margin: 1rem auto;
        padding: 0.75rem 1.5rem;
        background-color: #006d8c;
        color: white;
        border-radius: 0.5rem;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
    }

    .add-button:hover {
        background-color: #00546b;
    }
</style>

<h1 class="main-title">Master Kategori Artikel</h1>

<a href="{{ route('admin.artikel.kategori.create') }}" class="add-button">+ Tambah Kategori</a>

<div class="table-container">
    @if(session('success'))
        <p style="color: green; margin-bottom: 1rem;">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->name }}</td>
                    <td class="action-btns">
                        <a href="{{ route('admin.artikel.kategori.edit', $kategori->id) }}" class="btn">✏️ Edit</a>
                        <form action="{{ route('admin.artikel.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
