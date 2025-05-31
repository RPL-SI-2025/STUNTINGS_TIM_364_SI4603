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

        <x-dropdown-with-label
            label="Nama Imunisasi"
            name="immunization_id"
            :options="$immunizations->pluck('name', 'id')->toArray()"
            :selected="old('immunization_id', $immunization_record->immunization_id)"
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
            :value="old('immunized_at', \Carbon\Carbon::parse($immunization_record->immunized_at)->format('Y-m-d'))"
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
            :selected="old('status', $immunization_record->status)"
            required
            class="@error('status') border-red-500 @enderror"
        />
        @error('status')
            <div class="text-red-500 text-sm mb-3">{{ $message }}</div>
        @enderror

        <x-button type="submit" class="mt-4">Update</x-button>
        <x-button href="{{ route('orangtua.immunization_records.index') }}" type="button" class="mt-4 ml-2 bg-gray-600 hover:bg-gray-700">
            Kembali
        </x-button>
    </form>
</div>
@endsection
