@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h3 class="mb-0">Edit Tahapan Perkembangan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tahapan_perkembangan.update', $tahapanPerkembangan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_tahapan" class="form-label">Nama Tahapan</label>
                    <input type="text" class="form-control" id="nama_tahapan" name="nama_tahapan"
                        value="{{ old('nama_tahapan', $tahapanPerkembangan->nama_tahapan) }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $tahapanPerkembangan->deskripsi) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="umur_minimal_bulan" class="form-label">Umur Minimal (bulan)</label>
                        <input type="number" class="form-control" id="umur_minimal_bulan" name="umur_minimal_bulan"
                            value="{{ old('umur_minimal_bulan', $tahapanPerkembangan->umur_minimal_bulan) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="umur_maksimal_bulan" class="form-label">Umur Maksimal (bulan)</label>
                        <input type="number" class="form-control" id="umur_maksimal_bulan" name="umur_maksimal_bulan"
                            value="{{ old('umur_maksimal_bulan', $tahapanPerkembangan->umur_maksimal_bulan) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.tahapan_perkembangan.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-secondary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
