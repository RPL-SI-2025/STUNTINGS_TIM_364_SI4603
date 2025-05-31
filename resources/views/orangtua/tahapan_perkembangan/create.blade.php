@extends('layouts.app')

@section('title', 'Tambah Pencapaian')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Tambah Pencapaian Tahapan Perkembangan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('orangtua.tahapan_perkembangan.store') }}" method="POST">
                @csrf

                {{-- Tahapan Perkembangan --}}
                <div class="mb-3">
                    <label for="tahapan_perkembangan_id" class="form-label">Pilih Tahapan Perkembangan</label>
                    <select class="form-select" name="tahapan_perkembangan_id" id="tahapan_perkembangan_id" required>
                        <option value="">-- Pilih Tahapan --</option>
                        @foreach($tahapanPerkembangan as $tahapan)
                            <option value="{{ $tahapan->id }}" {{ old('tahapan_perkembangan_id') == $tahapan->id ? 'selected' : '' }}>
                                {{ $tahapan->nama_tahapan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal Pencapaian --}}
                <div class="mb-3">
                    <label for="tanggal_pencapaian" class="form-label">Tanggal Pencapaian</label>
                    <input type="date" class="form-control" name="tanggal_pencapaian" id="tanggal_pencapaian" value="{{ old('tanggal_pencapaian') }}" required>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="tercapai" {{ old('status') == 'tercapai' ? 'selected' : '' }}>Tercapai</option>
                        <option value="belum_tercapai" {{ old('status') == 'belum_tercapai' ? 'selected' : '' }}>Belum Tercapai</option>
                    </select>
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" name="catatan" id="catatan" rows="3">{{ old('catatan') }}</textarea>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('orangtua.tahapan_perkembangan.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar</a>
                    <button type="submit" class="btn text-white" style="background-color: #005f77;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection