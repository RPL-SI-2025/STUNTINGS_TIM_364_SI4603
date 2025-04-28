@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Imunisasi Anda</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('orangtua.immunization_records.create') }}" class="btn btn-primary mb-3">+ Tambah Riwayat Imunisasi</a>

    @if($records->isEmpty())
        <p>Anda belum memiliki riwayat imunisasi.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Imunisasi</th>
                    <th>Tanggal Diberikan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $record->immunization->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->immunized_at)->format('d-m-Y') }}</td>
                        <td>{{ $record->status }}</td>
                        <td>
                            <a href="{{ route('orangtua.immunization_records.edit', $record->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('orangtua.immunization_records.destroy', $record->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
