@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Riwayat Imunisasi Anda</h2>

    {{-- Tombol tambah --}}
    <div class="mb-4">
        <x-button href="{{ route('orangtua.immunization_records.create') }}">
            + Tambah Riwayat Imunisasi
        </x-button>
    </div>

    {{-- Tabel riwayat --}}
    @if($records->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki riwayat imunisasi.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 5%;">No</th>
                        <th>Nama Imunisasi</th>
                        <th style="width: 20%;">Tanggal Diberikan</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $index => $record)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $record->immunization->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->immunized_at)->format('d-m-Y') }}</td>
                            <td>{{ $record->status }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('orangtua.immunization_records.edit', $record->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form
                                        action="{{ route('orangtua.immunization_records.destroy', $record->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')"
                                        style="display: inline-block;"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
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
@endsection
