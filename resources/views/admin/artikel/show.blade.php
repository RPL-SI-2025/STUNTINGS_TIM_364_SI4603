@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $artikel->title }}</h1>
    <p>{!! nl2br(e($artikel->content)) !!}</p>
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary mt-3">
        ← Kembali ke daftar artikel
    </a>

</div>
@endsection
