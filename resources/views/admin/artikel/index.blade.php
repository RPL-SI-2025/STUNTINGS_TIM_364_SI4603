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
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header h1 {
        color: #005f77;
        font-size: 2rem;
        font-weight: bold;
    }

    .new-btn {
        background-color: #f3f4f6;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        transition: background 0.2s ease;
    }

    .new-btn:hover {
        background-color: #d1d5db;
    }

    .artikel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .card {
        background-color: #f3f4f6;
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .image {
        background-color: #d1d5db;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    .title {
        font-weight: bold;
        margin-bottom: 1rem;
        color: #374151;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .actions {
        display: flex;
        gap: 0.5rem;
    }

    .icon-btn {
        background-color: #e5e7eb;
        padding: 0.3rem 0.5rem;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        color: #374151;
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }

    .icon-btn:hover {
        background-color: #d1d5db;
    }

    .meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }



    .btn-read {
        background-color: #e5e7eb;
        padding: 0.3rem 0.6rem;
        border-radius: 10px;
        font-size: 0.85rem;
        text-decoration: none;
        color: #374151;
        font-weight: 500;
    }

    .btn-read:hover {
        background-color: #d1d5db;
    }
</style>

<div class="container">
    <div class="header">
        <h1>All Articles</h1>
        <a href="{{ route('admin.artikel.create') }}" class="new-btn">+ New Article</a>
    </div>

    <div class="artikel-grid">
        @forelse ($artikels as $artikel)
            <div class="card">
                <div class="image">🖼</div>
                <div class="title">{{ Str::limit($artikel->title, 60) }}</div>
                <div class="card-footer">
                    <div class="actions">
                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="icon-btn">✏️</a>
                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn">🗑️</button>
                        </form>
                    </div>
                    <div class="meta">
                        <span>👁️ {{ $artikel->views }}</span>
                        <a href="{{ route('admin.artikel.show', $artikel->id) }}" class="btn-read">Read All</a>
                    </div>


                </div>
            </div>
        @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #6b7280;">Belum ada artikel.</p>
        @endforelse
    </div>
</div>
@endsection
