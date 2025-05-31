@extends('layouts.app')

@section('title', 'Edit Imunisasi')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Imunisasi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.immunizations.update', $immunization->id) }}" method="POST">
        @csrf
        @method('PUT')

        
        <x-input-with-label
            label="Nama Imunisasi"
            name="name"
            type="text"
            :value="old('name', $immunization->name)"
            required
            class="@error('name') border-red-500 @enderror"
        />
        @error('name')
            <div class="text-red-500 text-sm mb-3">{{ $message }}</div>
        @enderror

        
        <x-input-with-label
            label="Usia"
            name="age"
            type="text"
            :value="old('age', $immunization->age)"
            class="@error('age') border-red-500 @enderror"
        />
        @error('age')
            <div class="text-red-500 text-sm mb-3">{{ $message }}</div>
        @enderror

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="description" class="form-label font-semibold">Deskripsi</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="form-control @error('description') border-red-500 @enderror"
            >{{ old('description', $immunization->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        
        <div class="mt-4 d-flex gap-2 flex-wrap">
            <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">Update</x-button>
            <x-button href="{{ route('admin.immunizations.index') }}" type="button" class="bg-gray-600 hover:bg-gray-700">Kembali</x-button>
        </div>
    </form>
</div>
@endsection
