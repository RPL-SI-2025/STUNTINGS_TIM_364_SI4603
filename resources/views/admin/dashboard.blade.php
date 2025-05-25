<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
@extends('layouts.app')
    <h1>Halo</h1>

    <form method="POST" action="{{ route('logout') }}">

        @csrf
        <button type="submit">Logout</button>
<a href="{{ route('admin.immunizations.index') }}" class="btn btn-primary">Cek Data Imunisasi</a>
<a href="{{ route('admin.detections.index') }}" class="btn btn-primary">Deteksi Stunting</a>
<a href="{{ route('admin.nutrition.index') }}" class="btn btn-primary">Rekomendasi Nutrisi</a>
<a href="{{ route('admin.tahapan_perkembangan.index') }}" class="btn btn-primary">Tahapan Perkembangan</a>
<a href="{{ route('admin.artikel.index') }}" class="btn btn-primary">Tambah Artikel</a>

    </form>
</body>
</html>
