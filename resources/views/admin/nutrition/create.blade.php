
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Tambah Menu Nutrisi</h2>
        <form action="{{ route('nutrition.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('nutrition.form')
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
    @endsection
