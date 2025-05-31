{{-- resources/views/namafile.blade.php --}}
@extends('layouts.app')

@section('title', 'Deteksi Stunting')

@section('content')
<div class="container mt-5">
    <h1 class="display-5 fw-bold mb-4">Form Deteksi Stunting</h1>

    {{-- Notifikasi error --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form Deteksi --}}
    <form action="{{ route('orangtua.detections.store') }}" method="POST">
        @csrf
        <input type="hidden" name="nama" value="{{ auth()->user()->nama_anak }}">

        <div class="mb-3">
            <label>Umur (bulan)</label>
            <input type="number" name="umur" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Berat Badan (kg)</label>
            <input type="number" step="0.1" name="berat_badan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tinggi Badan (cm)</label>
            <input type="number" step="0.1" name="tinggi_badan" class="form-control" required>
        </div>

        <x-button>Deteksi</x-button>
        <hr class="mt-5">
    </form>

    {{-- Hasil Deteksi Terbaru --}}
    @isset($hasil)
    <hr>
    <h3 class="mb-3 fw-bold">Hasil Deteksi Terbaru</h3>
    <div class="card p-3">
        <p><strong>Nama:</strong> {{ $hasil->nama }}</p>
        <p><strong>Umur:</strong> {{ $hasil->umur }} bulan</p>
        <p><strong>Jenis Kelamin:</strong> {{ $hasil->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
        <p><strong>Berat Badan:</strong> {{ $hasil->berat_badan }} kg</p>
        <p><strong>Tinggi Badan:</strong> {{ $hasil->tinggi_badan }} cm</p>
        <p><strong>Z-Score:</strong> {{ $hasil->z_score }}</p>
        <p><strong>Status:</strong>
            <span class="badge 
                {{ $hasil->status == 'Stunting' ? 'bg-danger' : ($hasil->status == 'Normal' ? 'bg-success' : 'bg-warning') }} ">
                {{ $hasil->status }}
            </span>
        </p>
    </div>
    @endisset

    {{-- Riwayat Deteksi --}}
<hr>
<h2 class="fw-bold mt-5 mb-4 fs-3">Riwayat Deteksi</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Umur (bulan)</th>
            <th>Jenis Kelamin</th>
            <th>Berat (kg)</th>
            <th>Tinggi (cm)</th>
            <th>Z-Score</th>
            <th>Status</th>
            <th>Waktu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($semua as $d)
        <tr>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->umur }}</td>
            <td>{{ $d->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $d->berat_badan }}</td>
            <td>{{ $d->tinggi_badan }}</td>
            <td>{{ $d->z_score }}</td>
            <td>
                <span class="badge 
                    {{ $d->status == 'Stunting' ? 'bg-danger' : ($d->status == 'Normal' ? 'bg-success' : 'bg-warning') }}">
                    {{ $d->status }}
                </span>
            </td>
            <td>{{ $d->created_at->format('d M Y H:i') }}</td>
            <td>
                <form action="{{ route('orangtua.detections.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs py-1 px-3">Hapus</x-button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Belum ada data deteksi.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
@endsection
