@extends('layouts.app')

@section('content')
<style>
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1280px;
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
        gap: 0.5rem;
    }

    .btn-icon-mini {
        background-color: #005f77;
        color: white;
        padding: 0.3rem 0.6rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        cursor: pointer;
    }

    .btn-icon-mini:hover {
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

    .card-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding-bottom: 2rem;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        padding: 0 2rem;
    }

    @media (max-width: 1024px) {
        .card-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .card-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .card-container {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background-color: #ffffff;
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
        padding: 0.4rem 0.8rem;
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
        margin: 1rem auto 0.5rem;
        padding: 0.6rem 1.3rem;
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

{{-- HEADER --}}
<div class="main-header">
    <h1 class="main-title">All Articles</h1>
    <div class="action-buttons">
        <button onclick="toggleFilter()" class="btn-icon-mini" title="Filter"><i class="fas fa-filter"></i></button>
        <button onclick="toggleSearch()" class="btn-icon-mini" title="Cari"><i class="fas fa-search"></i></button>
    </div>
</div>

<a href="{{ route('admin.artikel.create') }}" class="add-button">+ New Article</a>

{{-- FILTER MODAL --}}
<div id="filterModal" class="modal-overlay">
    <div class="modal-content">
        <h2>Pilih Kategori</h2>
        <form method="GET" action="{{ route('admin.artikel.index') }}">
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
                <button type="submit" class="btn">Apply</button>
                <a href="{{ route('admin.artikel.index') }}" class="btn" style="background-color: #9ca3af;">Reset</a>
                <button type="button" class="btn" style="background-color: #ef4444;" onclick="toggleFilter()">Tutup</button>
            </div>
        </form>
    </div>
</div>

{{-- SEARCH MODAL --}}
<div id="searchModal" class="modal-overlay">
    <div class="modal-content">
        <h2>Cari Artikel</h2>
        <form method="GET" action="{{ route('admin.artikel.index') }}">
            <input type="text" name="search" placeholder="Masukkan kata kunci..." value="{{ request('search') }}"
                   style="padding: 0.5rem 1rem; width: 100%; border-radius: 0.5rem; border: 1px solid #ccc; margin-bottom: 1rem;">
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                <button type="submit" class="btn">Cari</button>
                <button type="button" class="btn" style="background-color: #ef4444;" onclick="toggleSearch()">Tutup</button>
            </div>
        </form>
    </div>
</div>

{{-- ARTIKEL --}}
<div class="card-wrapper">
    <div class="card-container">
        @forelse ($artikels as $artikel)
            <div class="card">
                <img src="{{ $artikel->image ? asset('storage/' . $artikel->image) : asset('default-image.png') }}"
                     alt="Gambar Artikel" class="article-image">
                <div class="card-body">
                    <div class="card-title">{{ $artikel->title }}</div>
                    <div style="margin-bottom: 0.5rem;">
                        @foreach ($artikel->kategoris->take(3) as $kategori)
                            <span class="badge">#{{ $kategori->name }}</span>
                        @endforeach
                        @if ($artikel->kategoris->count() > 3)
                            <span class="badge">...</span>
                        @endif
                    </div>
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
        @empty
            <p style="text-align: center; color: #6b7280;">Belum ada artikel.</p>
        @endforelse
    </div>
</div>

{{-- KEMBALI --}}
@if(request('search') || request()->has('kategori'))
    <a href="{{ route('admin.artikel.index') }}" 
       class="btn" 
       style="position: fixed; bottom: 30px; right: 30px; padding: 0.6rem 1.5rem; font-size: 0.85rem; z-index: 1000;">
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

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $artikels->links('pagination::bootstrap-5') }}
</div>
@endsection
