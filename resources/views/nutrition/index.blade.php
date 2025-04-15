
<div class="container">
    <h2>Daftar Menu Nutrisi</h2>
    <a href="{{ route('nutrition.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>

    @foreach ($menus as $menu)
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
                <a href="{{ route('nutrition.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('nutrition.destroy', $menu->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

