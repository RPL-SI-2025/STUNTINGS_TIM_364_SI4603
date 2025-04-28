@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 fw-bold">Data Imunisasi</h4>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.immunizations.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Imunisasi
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama Imunisasi</th>
                    <th style="width: 10%;">Usia</th>
                    <th style="width: 45%;">Deskripsi</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($immunizations as $immunization)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td style="text-align: justify;">{{ $immunization->name }}</td>
                    <td class="text-center">{{ $immunization->age }}</td>
                    <td style="text-align: justify;">{{ $immunization->description }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.immunizations.edit', $immunization->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                        <form action="{{ route('admin.immunizations.destroy', $immunization->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    th, td {
        vertical-align: middle !important;
    }

    td {
        text-align: justify;
    }

    .btn {
        border-radius: 6px;
        font-size: 14px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .table > :not(caption) > * > * {
        background-color: #fff;
    }
</style>
@endsection
