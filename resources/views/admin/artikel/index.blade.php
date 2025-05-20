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
        flex: 1 1 calc(33.333% - 1rem);
        max-width: calc(33.333% - 1rem);
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

    .badge {
        display: inline-block;
        background-color: #d1fae5;
        color: #065f46;
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        margin: 0.2rem 0.2rem 0 0;
        border-radius: 0.5rem;
    }

    .card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .view-count {
        font-size: 0.9rem;
        color: #6b7280;
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

    #filterModal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.4);
        z-index: 999;
    }

    .modal-content {
        background: white;
        max-width: 600px;
        margin: 5% auto;
        padding: 2rem;
        border-radius: 1rem;
        position: relative;
    }

    .modal-content h2 {
        font-size: 1.5rem;
        color: #005f77;
        margin-bottom: 1rem;
    }

    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .filter-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
</style>

<h1 class="main-title">All Articles</h1>

<a href="{{ route('admin.artikel.create') }}" class="add-button">+ New Article</a>

<div style="text-align: center; margin-bottom: 1.5rem;">
    <button onclick="toggleModal()" class="btn">🔍 Filter Kategori</button>
</div>

<div id="filterModal">
    <div class="modal-content">
        <h2>Pilih Kategori</h2>

        <form method="GET" action="{{ route('admin.artikel.index') }}">
            <div class="filter-group">
                @foreach ($kategoris as $kategori)
                    <label>
                        <input
                            type="checkbox"
                            name="kategori[]"
                            value="{{ $kategori->id }}"
                            {{ in_array($kategori->id, $kategoriIds ?? []) ? 'checked' : '' }}
                        >
                        {{ $kategori->name }}
                    </label>
                @endforeach
            </div>

            <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                <button type="submit" class="btn">Apply</button>
                <a href="{{ route('admin.artikel.index') }}" class="btn" style="background-color:#9ca3af;">Reset</a>
                <button type="button" class="btn" style="background-color:#ef4444;" onclick="toggleModal()">Close</button>
            </div>
        </form>
    </div>
</div>

<div class="card-container">
    @forelse ($artikels as $artikel)
        <div class="card">
            @if ($artikel->image)
                <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Artikel" class="article-image">
            @else
                <img src="{{ asset('default-image.png') }}" alt="Gambar Default" class="article-image">
            @endif

            <div class="card-body">
                <div>
                    <div class="card-title">{{ $artikel->title }}</div>
                    <div style="margin-bottom: 0.5rem;">
                        @foreach ($artikel->kategoris->take(3) as $kategori)
                            <span class="badge">#{{ $kategori->name }}</span>
                        @endforeach
                        @if ($artikel->kategoris->count() > 3)
                            <span class="badge">...</span>
                        @endif
                    </div>
                </div>

                <div style="margin-top: auto;">
                    <div class="card-actions">
                        <div class="view-count">👁 {{ $artikel->views ?? 0 }}</div>
                        <div style="display: flex; gap: 0.4rem;">
                            <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn-icon" title="Edit">✏️</a>
                            <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete" onclick="return confirm('Hapus artikel ini?')">🗑️</button>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('admin.artikel.show', $artikel->id) }}" class="btn" style="width: 100%; text-align: center;">Read All</a>
                </div>
            </div>
        </div>
    @empty
        <p style="text-align: center; color: #6b7280;">Belum ada artikel.</p>
    @endforelse
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('filterModal');
        modal.style.display = (modal.style.display === 'none' || modal.style.display === '') ? 'block' : 'none';
    }
</script>
@endsection
