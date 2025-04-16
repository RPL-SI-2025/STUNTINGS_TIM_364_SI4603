@extends('layouts.app')

@section('content')

<div class="row row-cols-1 row-cols-md-2 g-4">
@foreach ($menus as $menu)
  <div class="col">
    <div class="card">
    @if ($menu->image)
    <a href="{{ route('nutritionUs.show', $menu->id) }}" >
      <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="Gambar Menu">
    </a>
    @endif
      <div class="card-body">
        <h5 class="card-title">{{ $menu->name }} ({{ ucfirst($menu->category) }})</h5>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection

