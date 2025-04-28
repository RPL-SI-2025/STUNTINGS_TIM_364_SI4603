@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 fw-bold">Edit Imunisasi</h4>

    <form action="{{ route('admin.immunizations.update', $immunization->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Imunisasi</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $immunization->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label fw-semibold">Usia</label>
            <input type="text" name="age" class="form-control" value="{{ old('age', $immunization->age) }}">
        </div>

        <div class="mb-3">
        <label for="description" class="form-label fw-semibold">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $immunization->description) }}</textarea>
        </div>

        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.immunizations.index') }}" class="btn btn-secondary">Batal</a>
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
