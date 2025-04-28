@extends('layouts.app')

@section('content')

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach ($menus as $menu)
        <div class="col mb-4"> {{-- Tambah mb-4 di sini --}}
            <div class="card h-100 shadow-sm border-0">
                @if ($menu->image)
                    <a href="{{ route('nutritionUs.show', $menu->id) }}">
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
