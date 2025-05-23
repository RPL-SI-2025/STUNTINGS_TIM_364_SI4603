
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Menu Nutrisi</h2>
    <form action="{{ route('admin.nutrition.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.nutrition.form', ['menu' => $menu])
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
