@extends('layouts.app')

@section('title', 'Riwayat Imunisasi Anak')

@section('content')
<style>
    .main-title {
        color: #005f77;
        font-size: 1.75rem;
    }
</style>

<div class="container px-0">
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 1280px; margin: 0 auto;">
                <h1 class="main-title mb-0">Riwayat Imunisasi Anak</h1>
                <a href="{{ route('orangtua.immunization_records.create') }}"
                   class="btn text-white"
                   style="background-color: #005f77;">
                    + Tambah Riwayat
                </a>
            </div>

            {{-- TABEL --}}
            @if($records->isEmpty())
                <div class="alert alert-info text-center">
                    Anda belum memiliki riwayat imunisasi.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Imunisasi</th>
                                <th style="width: 20%;">Tanggal Diberikan</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $index => $record)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start">{{ $record->immunization->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record->immunized_at)->format('d-m-Y') }}</td>
                                    <td>{{ $record->status }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('orangtua.immunization_records.edit', $record->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Edit
                                            </a>
                                            <form action="{{ route('orangtua.immunization_records.destroy', $record->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
