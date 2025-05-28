@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.nutrition.index') }}">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                {{-- Filter Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown">
                        Filter Kategori
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="kategoriDropdown">
                        <li><a class="dropdown-item" href="{{ route('orangtua.nutritionUs.index') }}">Semua</a></li>
                        <li><a class="dropdown-item" href="{{ route('orangtua.nutritionUs.index', ['kategori' => 'pagi']) }}">Pagi</a></li>
                        <li><a class="dropdown-item" href="{{ route('orangtua.nutritionUs.index', ['kategori' => 'siang']) }}">Siang</a></li>
                        <li><a class="dropdown-item" href="{{ route('orangtua.nutritionUs.index', ['kategori' => 'malam']) }}">Malam</a></li>
                        <li><a class="dropdown-item" href="{{ route('orangtua.nutritionUs.index', ['kategori' => 'snack']) }}">Snack</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>



<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach ($menus as $menu)
        <div class="col mb-4"> {{-- Tambah mb-4 di sini --}}
            <div class="card h-100 shadow-sm border-0">
                @if ($menu->image)
                    <a href="{{ route('orangtua.nutritionUs.show', $menu->id) }}">
                        <img src="{{ asset('storage/' . $menu->image) }}"
                             class="card-img-top img-fluid object-fit-cover"
                             alt="Gambar Menu"
                             style="height: 200px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                    </a>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->name }} <small class="text-muted">({{ ucfirst($menu->category) }})</small></h5>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
