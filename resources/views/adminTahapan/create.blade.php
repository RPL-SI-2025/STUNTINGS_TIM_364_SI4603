@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Tahapan Perkembangan Anak</h2>
    <form action="{{ route('admin.tahapanPerkembangan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kategori" class="form-label">Umur (Kategori)</label>
            <input type="text" name="kategori" class="form-control" id="kategori" placeholder="Contoh: 0-12 bulan" required>
        </div>

        <div class="mb-3">
            <label for="tahapan" class="form-label">Tahapan Perkembangan</label>
            <input type="text" name="tahapan" class="form-control" id="tahapan" placeholder="Contoh: Merangkak" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Keterangan / Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
