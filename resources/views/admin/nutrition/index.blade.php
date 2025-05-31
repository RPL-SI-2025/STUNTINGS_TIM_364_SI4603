@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">Daftar Menu Nutrisi</h2>

    {{-- Tombol Tambah Menu --}}
    <x-button href="{{ route('admin.nutrition.create') }}" class="mb-4 inline-flex items-center gap-1">
        <i class="bi bi-plus-circle"></i> Tambah Menu
    </x-button>

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
                        <x-button href="{{ route('admin.nutrition.edit', $menu->id) }}" type="button" class="btn-sm inline-flex items-center gap-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </x-button>

                        <form action="{{ route('admin.nutrition.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" class="btn-sm inline-flex items-center gap-1 bg-red-600 hover:bg-red-700">
                                <i class="bi bi-trash3"></i> Hapus
                            </x-button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
