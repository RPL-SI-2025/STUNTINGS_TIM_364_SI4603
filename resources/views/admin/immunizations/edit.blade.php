@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 fw-bold">Edit Imunisasi</h4>

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

        <div class="mb-4">
            <label for="description" class="form-label fw-semibold">Deskripsi</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="form-control @error('description') is-invalid @enderror"
            >{{ old('description', $immunization->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-3 d-flex gap-2 flex-wrap">
            <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">Simpan</x-button>
            <x-button href="{{ route('admin.immunizations.index') }}" type="button" class="bg-gray-600 hover:bg-gray-700">Batal</x-button>
        </div>
    </form>
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        padding-top: 20px;
    }

    .container {
        max-width: 700px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        text-align: justify;
    }

    .form-control {
        border-radius: 6px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ced4da;
    }

    .form-label {
        margin-bottom: 6px;
    }

    .btn {
        border-radius: 6px;
        font-size: 14px;
        padding: 10px 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn:hover {
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .btn {
            width: 100%;
        }

        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
</style>
@endsection
