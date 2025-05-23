
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Tambah Menu Nutrisi</h2>
        <form action="{{ route('admin.nutrition.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.nutrition.form')
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
    @endsection
