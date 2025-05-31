@extends('layouts.app')

@section('title', 'Tambah Imunisasi')

@section('content')
<div class="container px-0">
    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-4 main-title" style="color: #005f77; font-size: 1.75rem;">
                Tambah Imunisasi
            </h1>

            <form action="{{ route('admin.immunizations.store') }}" method="POST">
                @csrf

                {{-- Nama Imunisasi --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Imunisasi</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Usia --}}
                <div class="mb-3">
                    <label for="age" class="form-label fw-semibold">Usia</label>
                    <input type="text" name="age" id="age"
                           class="form-control @error('age') is-invalid @enderror"
                           value="{{ old('age') }}">
                    @error('age')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn text-white" style="background-color: #005f77;">
                        Simpan
                    </button>
                    <a href="{{ route('admin.immunizations.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
