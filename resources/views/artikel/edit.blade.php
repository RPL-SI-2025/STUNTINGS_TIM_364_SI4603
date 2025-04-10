@extends('layouts.app')

@section('content')
<h1>Edit Artikel</h1>
<form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Judul:</label>
    <input type="text" name="judul" value="{{ $artikel->judul }}" required><br><br>

    <label>Isi:</label>
    <textarea name="isi" required>{{ $artikel->isi }}</textarea><br><br>

    <button type="submit">Update</button>
</form>
@endsection
