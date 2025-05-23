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
        max-width: 900px;
        margin: 2rem auto;
        background-color: #ffffff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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


    .artikel-title {
        font-size: 2rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 1rem;
        text-align: center;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .artikel-content {
        color: #374151;
        line-height: 1.8;
        white-space: pre-line;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .back-button {
        display: inline-block;
        margin-top: 2rem;
        background-color: #005f77;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #014f66;
    }
</style>

<div class="container">
    <div class="artikel-title">{{ $artikel->title }}</div>

    @if ($artikel->image)
        <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Artikel" class="artikel-image">
    @else
        <img src="{{ asset('default-image.png') }}" alt="Gambar Default" class="artikel-image">
    @endif

    <div class="artikel-content">
        {!! nl2br(e($artikel->content)) !!}
    </div>

    <a href="{{ route('admin.artikel.index') }}" class="back-button">← Kembali ke daftar artikel</a>
</div>
@endsection
