@extends('layouts.app')

@section('content')
<style>
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .main-title {
        color: #005f77;
        font-size: 2rem;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .hidden {
        display: none;
    }
</style>

<div class="container">

    {{-- Header Judul dan Tombol --}}
    <div class="main-header">
        <h1 class="main-title">Data Deteksi Stunting</h1>
        <div class="action-buttons">
            <x-button-icon icon="filter" title="Filter" onclick="toggleFilter()" />
            <x-button-icon icon="search" title="Cari" onclick="toggleSearch()" />
        </div>
    </div>

    {{-- Tabel --}}
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur (bulan)</th>
                <th>Jenis Kelamin</th>
                <th>Berat Badan (kg)</th>
                <th>Tinggi Badan (cm)</th>
                <th>Z-Score</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($semua as $d)
                <tr>
                    <td>{{ $d->user->nama_anak ?? '-' }}</td>
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
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data deteksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Modal Search --}}
    <x-modal-search :action="route('admin.detections.index')" />

</div>

{{-- Script untuk toggle modal --}}
<script>
    function toggleSearch() {
        const modal = document.getElementById('searchModal');
        if (modal) modal.classList.toggle('hidden');
    }

    function toggleFilter() {
        alert('Fitur filter belum tersedia.');
    }
</script>
@endsection
