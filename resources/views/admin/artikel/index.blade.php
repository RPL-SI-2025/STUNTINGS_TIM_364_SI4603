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

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        padding: 0 2rem;
    }

    .card {
        background-color: #ffffff;
        width: 250px;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
    }

    .article-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background-color: #f3f4f6;
    }

    .card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .card-title {
        font-weight: bold;
        color: #1f2937;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    .btn {
        background-color: #005f77;
        color: white;
        padding: 0.5rem 0.75rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #014f66;
    }

    .btn-icon {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .icon {
        margin-right: 0.25rem;
    }

    .view-count {
        font-size: 0.9rem;
        color: #6b7280;
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

<h1 class="main-title">All Articles</h1>

<a href="{{ route('admin.artikel.create') }}" class="add-button">+ New Article</a>

<div class="card-container">
    @foreach ($artikels as $artikel)
        <div class="card">
            @if ($artikel->image)
                <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Artikel" class="article-image">
            @else
                <img src="{{ asset('default-image.png') }}" alt="Gambar Default" class="article-image">
            @endif

            <div class="card-body">
                <div class="card-title">{{ $artikel->title }}</div>

                <div class="card-actions">
                    <div class="view-count">👁 {{ $artikel->views ?? 0 }}</div>

                    <div>
                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn-icon" title="Edit">✏️</a>
                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" title="Delete" onclick="return confirm('Hapus artikel ini?')">🗑️</button>
                        </form>
                    </div>
                </div>

                <a href="{{ route('admin.artikel.show', $artikel->id) }}" class="btn" style="margin-top: 0.75rem;">Read All</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
