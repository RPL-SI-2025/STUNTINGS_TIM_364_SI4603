@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Riwayat Imunisasi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('orangtua.immunization_records.update', $immunization_record->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="immunization_id" class="form-label">Nama Imunisasi</label>
            <select name="immunization_id" id="immunization_id" class="form-select @error('immunization_id') is-invalid @enderror">
                @foreach($immunizations as $immunization)
                    <option value="{{ $immunization->id }}" {{ $immunization->id == $immunization_record->immunization_id ? 'selected' : '' }}>
                        {{ $immunization->name }}
                    </option>
                @endforeach
            </select>
            @error('immunization_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="immunized_at" class="form-label">Tanggal Imunisasi</label>
            <input type="date" name="immunized_at" id="immunized_at" 
                class="form-control @error('immunized_at') is-invalid @enderror"
                value="{{ old('immunized_at', \Carbon\Carbon::parse($immunization_record->immunized_at)->format('Y-m-d')) }}">
            @error('immunized_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="Sudah" {{ old('status', $immunization_record->status) == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                <option value="Belum" {{ old('status', $immunization_record->status) == 'Belum' ? 'selected' : '' }}>Belum</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('orangtua.immunization_records.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
