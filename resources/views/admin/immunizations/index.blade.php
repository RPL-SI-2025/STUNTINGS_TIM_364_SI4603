@extends('layouts.app')

@section('title', 'Data Vaksin Imunisasi')

@section('content')
<style>
    .badge {
        display: inline-block;
        background: #e0f2fe;
        color: #0284c7;
        border-radius: 0.5rem;
        padding: 0.2rem 0.7rem;
        font-size: 0.85rem;
        margin-right: 0.3rem;
        margin-bottom: 0.2rem;
    }
</style>

<div class="container px-0">
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 1280px; margin: 0 auto;">
                <h1 class="main-title mb-0" style="color: #005f77; font-size: 1.75rem;">Data Vaksin Imunisasi</h1>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.immunizations.create') }}"
                        class="btn text-white"
                        style="background-color: #005f77;">+ Tambah Imunisasi
                    </a>
                    <button class="btn btn-outline-secondary" title="Cari Imunisasi"
                            onclick="document.getElementById('searchModal').classList.remove('hidden')">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

            {{-- MODAL SEARCH --}}
            <div id="searchModal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-10 z-50 flex items-center justify-center">
                <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                    <form method="GET" action="{{ route('admin.immunizations.index') }}">
                        <div class="mb-4 font-semibold text-sky-900">Cari Nama Imunisasi</div>
                        <input type="text" name="name" class="form-control mb-4" placeholder="Masukkan nama imunisasi..." value="{{ request('name') }}">
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-4 py-2 rounded text-white" style="background-color: #005f77;">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.immunizations.index') }}" class="px-4 py-2 rounded text-white" style="background-color: #005f77;">Reset</a>
                            <button type="button" onclick="document.getElementById('searchModal').classList.add('hidden')" class="px-4 py-2 rounded text-white" style="background-color: #005f77;">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL --}}
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Imunisasi</th>
                            <th>Usia</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($immunizations as $index => $immunization)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $immunization->name }}</td>
                                <td>{{ $immunization->age }}</td>
                                <td class="text-start">{{ $immunization->description }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.immunizations.edit', $immunization->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.immunizations.destroy', $immunization->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection