@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 1.5rem;
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .judul-artikel {
        font-size: 2rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 0.75rem;
        text-align: center;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .artikel-meta {
        font-size: 0.95rem;
        color: #6b7280;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .artikel-image {
        width: 100%;
        max-width: 600px;
        max-height: 300px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin: 0 auto 1.5rem;
        display: block;
    }

    .content {
        color: #374151;
        line-height: 1.8;
        white-space: pre-line;
        word-break: break-word;
    }

    .btn-back {
        display: inline-block;
        margin-top: 2rem;
        padding: 0.5rem 1rem;
        background-color: #006d8c;
        color: white;
        border-radius: 0.5rem;
        font-weight: bold;
        text-decoration: none;
        font-size: 0.95rem;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #00546b;
    }
</style>

<div class="container">
    <h1 class="judul-artikel">{{ $artikel->title }}</h1>

    <div class="artikel-meta">
        <strong>Kategori:</strong> {{ $artikel->kategoris->pluck('name')->join(', ') }}
    </div>

    @if ($artikel->image)
        <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Artikel" class="artikel-image">
    @else
        <img src="{{ asset('default-image.png') }}" alt="Gambar Default" class="artikel-image">
    @endif

    <div class="content">
        {!! nl2br(e($artikel->content)) !!}
    </div>

    <a href="{{ route('orangtua.artikel.index') }}" class="btn-back">← Kembali ke Daftar Artikel</a>
</div>
@endsection
