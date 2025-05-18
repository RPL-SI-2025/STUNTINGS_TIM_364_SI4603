@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Riwayat Imunisasi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('orangtua.immunization_records.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="immunization_id" class="form-label">Nama Imunisasi</label>
            <select name="immunization_id" id="immunization_id" class="form-control @error('immunization_id') is-invalid @enderror" required>
                <option value="">Pilih Imunisasi</option>
                @foreach($immunizations as $immunization)
                    <option value="{{ $immunization->id }}">{{ $immunization->name }}</option>
                @endforeach
            </select>
            @error('immunization_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="immunized_at" class="form-label">Tanggal Imunisasi</label>
            <input type="date" name="immunized_at" id="immunized_at" class="form-control @error('immunized_at') is-invalid @enderror" required>
            @error('immunized_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="Sudah">Sudah</option>
                <option value="Belum">Belum</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('orangtua.immunization_records.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
