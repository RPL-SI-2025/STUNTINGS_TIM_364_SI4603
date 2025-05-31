@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Riwayat Imunisasi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('orangtua.immunization_records.store') }}" method="POST">
        @csrf

        <x-dropdown-with-label
            label="Nama Imunisasi"
            name="immunization_id"
            :options="$immunizations->pluck('name', 'id')->toArray()"
            :selected="old('immunization_id')"
            required
            class="@error('immunization_id') border-red-500 @enderror"
        />
        @error('immunization_id')
            <div class="text-red-500 text-sm mb-3">{{ $message }}</div>
        @enderror

        <x-input-with-label
            label="Tanggal Imunisasi"
            name="immunized_at"
            type="date"
            value="{{ old('immunized_at') }}"
            required
            class="@error('immunized_at') border-red-500 @enderror"
        />
        @error('immunized_at')
            <div class="text-red-500 text-sm mb-3">{{ $message }}</div>
        @enderror

        <x-dropdown-with-label
            label="Status"
            name="status"
            :options="['Sudah' => 'Sudah', 'Belum' => 'Belum']"
            :selected="old('status')"
            required
            class="@error('status') border-red-500 @enderror"
        />
        @error('status')
            <div class="text-red-500 text-sm mb-3">{{ $message }}</div>
        @enderror

        <x-button type="submit" class="mt-4">Simpan</x-button>
        <x-button href="{{ route('orangtua.immunization_records.index') }}" type="button" class="mt-4 ml-2 bg-gray-600 hover:bg-gray-700">
            Kembali
        </x-button>
    </form>
</div>
@endsection
