@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Orangtua Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}</p>

    <!-- Button to view immunization records -->
    <a href="{{ route('orangtua.immunization_records.index') }}" class="btn btn-primary mt-3">Riwayat Imunisasi</a>
    <a href="{{ route('orangtua.tahapan_perkembangan.index') }}" class="btn btn-primary mt-3">tahapan perkembangan</a>
    <a href="{{ route('bmi') }}" class="btn btn-primary mt-3">Hitung BMI</a>
    <a href="{{ route('orangtua.nutritionUs.index') }}" class="btn btn-primary mt-3">rekomendasi nutrisi harian</a>
    <!-- Additional links or information can be added here in the future -->
</div>
@endsection
