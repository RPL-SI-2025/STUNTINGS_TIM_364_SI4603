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
</style>

{{-- HEADER --}}
<div class="main-header">
    <h1 class="main-title">All Articles</h1>
    <div class="action-buttons" style="display: flex; gap: 0.5rem;">
        <x-button-icon icon="fas fa-filter" title="Filter" onclick="toggleFilter()" />
        <x-button-icon icon="fas fa-search" title="Cari" onclick="toggleSearch()" />
    </div>
</div>

<a href="{{ route('admin.artikel.create') }}" class="add-button">+ New Article</a>

{{-- FILTER MODAL --}}
<x-modal-filter :kategoris="$kategoris" :kategoriIds="$kategoriIds ?? []" />

{{-- SEARCH MODAL --}}
<x-modal-search :search="request('search')" />

{{-- ARTIKEL --}}
<div class="card-wrapper">
    <div class="card-container">
        @forelse ($artikels as $artikel)
            <div class="card">
                <img src="{{ $artikel->image ? asset('storage/' . $artikel->image) : asset('default-image.png') }}"
                     alt="Gambar Artikel" class="article-image" style="width: 100%; height: 180px; object-fit: cover; background-color: #f3f4f6;">
                <div class="card-body" style="padding: 1rem; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1;">
                    <div class="card-title" style="font-weight: bold; color: #1f2937; font-size: 1.1rem; margin-bottom: 0.5rem;">
                        {{ $artikel->title }}
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        @foreach ($artikel->kategoris->take(3) as $kategori)
                            <span class="badge">#{{ $kategori->name }}</span>
                        @endforeach
                        @if ($artikel->kategoris->count() > 3)
                            <span class="badge">...</span>
                        @endif
                    </div>
                    <div class="card-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <div class="view-count" style="font-size: 0.9rem; color: #6b7280;">👁 {{ $artikel->views ?? 0 }}</div>
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

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $artikels->links('pagination::bootstrap-5') }}
</div>
@endsection
