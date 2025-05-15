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

    .btn-filter-open {
        display: block;
        margin: 0 auto 1rem auto;
        background-color: #005f77;
        color: white;
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .btn-filter-open:hover {
        background-color: #014f66;
    }

    /* Modal styling */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 50;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    .modal h2 {
        font-size: 1.4rem;
        margin-bottom: 1rem;
        color: #005f77;
    }

    .modal form {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .modal label {
        font-size: 0.9rem;
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-modal {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .btn-modal.filter {
        background-color: #005f77;
        color: white;
    }

    .btn-modal.reset {
        background-color: #9ca3af;
        color: white;
    }

    .btn-modal.close {
        background-color: #ef4444;
        color: white;
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
        height: 170px;
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
        font-weight: 600;
        color: #1f2937;
        font-size: 1.05rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        height: 2.6em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
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
        margin-top: 0.75rem;
    }

    .view-count {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .btn {
        background-color: #005f77;
        color: white;
        padding: 0.4rem 0.9rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #014f66;
    }

    .empty-message {
        text-align: center;
        font-size: 1rem;
        color: #6b7280;
        margin: 3rem 0;
    }
</style>

<h1 class="main-title">Artikel untuk Anda</h1>

<!-- Tombol buka modal -->
<button onclick="toggleModal()" class="btn-filter-open">Filter</button>

<!-- Modal Popup -->
<div id="filterModal" class="modal-overlay">
    <div class="modal">
        <h2>Filter Berdasarkan Kategori</h2>
        <form method="GET" action="{{ route('orangtua.artikel.index') }}">
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                @foreach ($kategoris as $kategori)
                    <label>
                        <input type="checkbox" name="kategori[]" value="{{ $kategori->id }}"
                            {{ in_array($kategori->id, $kategoriIds ?? []) ? 'checked' : '' }}>
                        {{ $kategori->name }}
                    </label>
                @endforeach
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn-modal filter">🔍 Filter</button>
                <a href="{{ route('orangtua.artikel.index') }}" class="btn-modal reset">❌ Reset</a>
                <button type="button" onclick="toggleModal()" class="btn-modal close">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Konten Artikel -->
<div class="card-container">
    @forelse ($artikels as $artikel)
        <div class="card">
            @if ($artikel->image)
                <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Artikel" class="article-image">
            @else
                <img src="{{ asset('default-image.png') }}" alt="Gambar Default" class="article-image">
            @endif

            <div class="card-body">
                <div class="card-title">{{ Str::limit($artikel->title, 60) }}</div>

                <div style="margin-bottom: 0.5rem;">
                    @foreach ($artikel->kategoris as $kategori)
                        <span class="badge">#{{ $kategori->name }}</span>
                    @endforeach
                </div>

                <div class="card-actions">
                    <div class="view-count">👁 {{ $artikel->views ?? 0 }}</div>
                    <a href="{{ route('orangtua.artikel.show', $artikel->id) }}" class="btn">Baca</a>
                </div>
            </div>
        </div>
    @empty
        <p class="empty-message">Belum ada artikel yang tersedia.</p>
    @endforelse
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('filterModal');
        modal.style.display = (modal.style.display === 'none' || modal.style.display === '') ? 'flex' : 'none';
    }
</script>
@endsection
