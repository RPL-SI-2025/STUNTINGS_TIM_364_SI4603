@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">Stuntings Admin</h2>

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button type="submit" class="bg-red-600 hover:bg-red-700 text-white">
                Logout
            </x-button>
        </form>
    </div>

    {{-- Navigasi Menu --}}
    <div class="d-flex flex-wrap gap-2">
        <x-button href="{{ route('admin.immunizations.index') }}">Cek Data Imunisasi</x-button>
        <x-button href="{{ route('admin.detections.index') }}">Deteksi Stunting</x-button>
        <x-button href="{{ route('admin.nutrition.index') }}">Rekomendasi Nutrisi</x-button>
        <x-button href="{{ route('admin.tahapan_perkembangan.index') }}">Tahapan Perkembangan</x-button>
        <x-button href="{{ route('admin.artikel.index') }}">Tambah Artikel</x-button>
    </div>
</div>
@endsection
