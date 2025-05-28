@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4 text-primary">Data Vaksin Imunisasi</h4>

    {{-- Form Search --}}
    <form action="{{ route('admin.immunizations.index') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="name" class="form-control shadow-sm" placeholder="Cari berdasarkan nama imunisasi..." value="{{ request('name') }}">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="{{ route('admin.immunizations.index') }}" class="btn btn-outline-secondary shadow-sm ms-2">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>
            <div class="col-md text-end">
                <a href="{{ route('admin.immunizations.create') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Imunisasi
                </a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive rounded shadow-sm">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Imunisasi</th>
                    <th style="width: 10%;">Usia</th>
                    <th style="width: 40%;">Deskripsi</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($immunizations as $immunization)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $immunization->name }}</td>
                        <td class="text-center">{{ $immunization->age }}</td>
                        <td>{{ $immunization->description }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.immunizations.edit', $immunization->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.immunizations.destroy', $immunization->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
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

{{-- Optional Custom Styling --}}
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', sans-serif;
    }

    .table thead th {
        background-color: #e9ecef;
        vertical-align: middle;
    }

    .table td, .table th {
        vertical-align: middle;
        font-size: 14px;
    }

    .btn {
        font-size: 13px;
    }

    input::placeholder {
        font-style: italic;
        color: #888;
    }

    h4 {
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
    }
</style>
@endsection
