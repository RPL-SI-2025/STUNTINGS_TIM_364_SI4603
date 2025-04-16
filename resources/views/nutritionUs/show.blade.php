
@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Detail Menu</h2>

    <div class="card mb-3">
        <div class="row">
            <div class="col-md-3">
                @if ($menu->image)
                    <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid" alt="Gambar Menu">
                @endif
            </div>
            <div class="col-md-9">
                <h4>{{ $menu->name }} <small>({{ ucfirst($menu->category) }})</small></h4>
                <p><strong>Nutrisi:</strong> {{ $menu->nutrition }}</p>
                <p><strong>Bahan:</strong> {{ $menu->ingredients }}</p>
                <p><strong>Cara Buat:</strong> {{ $menu->instructions }}</p>
            </div>
        </div>
    </div>
</div>

@endsection