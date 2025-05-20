@extends('layouts.app')

@section('content')

<style>
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1000px;
        margin: 2rem auto 1rem;
        padding: 0 1rem;
    }

    .main-title {
        color: #005f77;
        font-size: 2rem;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .btn-icon {
        background-color: #005f77;
        color: white;
        padding: 0.6rem 0.9rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-icon:hover {
        background-color: #014f66;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        max-width: 600px;
        width: 90%;
    }

    .modal-content h2 {
        margin-bottom: 1rem;
        color: #005f77;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        padding: 0 2rem;
    }

    .card {
        background: white;
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
    }

    .card-body {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.05rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .badge {
        background: #d1fae5;
        color: #065f46;
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 0.5rem;
        margin-right: 0.25rem;
        display: inline-block;
    }

    .card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }

    .view-count {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .btn {
        background-color: #005f77;
        color: white;
        padding: 0.4rem 0.9rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        text-align: center;
        text-decoration: none;
    }

    .empty-message {
        text-align: center;
        font-size: 1rem;
        color: #6b7280;
        margin: 3rem 0;
    }

</style>

<div class="main-header">
    <h1 class="main-title">Artikel untuk Anda</h1>
    <div class="action-buttons">
        <button class="btn-icon" onclick="toggleFilter()">filter</button>
        <button class="btn-icon" onclick="toggleSearch()">🔎</button>
    </div>
</div>

{{-- Modal Filter --}}
<div id="filterModal" class="modal-overlay">
    <div class="modal-content">
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
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <button type="submit" class="btn">Terapkan</button>
                <a href="{{ route('orangtua.artikel.index') }}" class="btn" style="background-color: #9ca3af;">Reset</a>
                <button type="button" class="btn" style="background-color: #ef4444;" onclick="toggleFilter()">Tutup</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Search --}}
<div id="searchModal" class="modal-overlay">
    <div class="modal-content">
        <h2>Cari Artikel</h2>
        <form method="GET" action="{{ route('orangtua.artikel.index') }}">
            <input type="text" name="search" placeholder="Masukkan kata kunci..." value="{{ request('search') }}"
                   style="padding: 0.5rem 1rem; width: 100%; border-radius: 0.5rem; border: 1px solid #ccc; margin-bottom: 1rem;">
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                <button type="submit" class="btn">Cari</button>
                <button type="button" class="btn" style="background-color: #ef4444;" onclick="toggleSearch()">Tutup</button>
            </div>
        </form>
    </div>
</div>

{{-- Artikel --}}
<div class="card-container">
    @forelse ($artikels as $artikel)
        <div class="card">
            <img src="{{ $artikel->image ? asset('storage/' . $artikel->image) : asset('default-image.png') }}"
                 alt="Gambar Artikel" class="article-image">
            <div class="card-body">
                <div class="card-title">{{ Str::limit($artikel->title, 60) }}</div>
                <div>
                    @foreach ($artikel->kategoris->take(3) as $kategori)
                        <span class="badge">#{{ $kategori->name }}</span>
                    @endforeach
                    @if ($artikel->kategoris->count() > 3)
                        <span class="badge">...</span>
                    @endif
                </div>
                <div class="card-actions">
                    <div class="view-count">👁 {{ $artikel->views ?? 0 }}</div>
                    <a href="{{ route('orangtua.artikel.show', $artikel->id) }}" class="btn">Read All</a>
                </div>
            </div>
        </div>
    @empty
        <p class="empty-message">Belum ada artikel yang tersedia.</p>
    @endforelse
</div>

@if(request('search') || request()->has('kategori'))
    <a href="{{ route('orangtua.artikel.index') }}" 
       class="btn" 
       style="position: fixed; bottom: 30px; right: 30px; padding: 0.6rem 1.5rem; font-size: 0.9rem; z-index: 1000;">
        ← Kembali ke Semua Artikel
    </a>
@endif

<script>
    function toggleFilter() {
        const modal = document.getElementById('filterModal');
        modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
    }

    function toggleSearch() {
        const modal = document.getElementById('searchModal');
        modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
    }
</script>
@endsection
