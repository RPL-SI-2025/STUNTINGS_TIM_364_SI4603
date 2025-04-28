@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">Daftar Menu Nutrisi</h2>
    <a href="{{ route('nutrition.create') }}" class="btn btn-primary mb-4">
        <i class="bi bi-plus-circle me-1"></i> Tambah Menu
    </a>

    @foreach ($menus as $menu)
    <div class="card mb-4 shadow-sm border-0">
        <div class="row g-0">
            <div class="col-md-3">
                @if ($menu->image)
                    <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Gambar Menu" style="object-fit: cover;">
                @endif
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <h4 class="card-title">{{ $menu->name }} <small class="text-muted">({{ ucfirst($menu->category) }})</small></h4>
                    <p><strong>Nutrisi:</strong> {{ $menu->nutrition }}</p>
                    <p><strong>Bahan:</strong> {{ $menu->ingredients }}</p>
                    <p><strong>Cara Buat:</strong> {{ $menu->instructions }}</p>
                    
                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('nutrition.edit', $menu->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </a>
                        <form action="{{ route('nutrition.delet', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash3 me-1"></i>Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
