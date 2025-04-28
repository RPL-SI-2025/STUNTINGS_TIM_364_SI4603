<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahapan Perkembangan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6c757d;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.tahapan_perkembangan.index') }}">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tahapan_perkembangan.index') }}">Tahapan Perkembangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tahapan_perkembangan.create') }}">Tambah Tahapan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-secondary">Daftar Tahapan Perkembangan</h1>
            <a href="{{ route('admin.tahapan_perkembangan.create') }}" class="btn btn-secondary">Tambah Tahapan</a>
        </div>

        @if(session('success'))
            <div class="alert alert-secondary">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead style="background-color: #dee2e6;">
                    <tr>
                        <th>ID</th>
                        <th>Nama Tahapan</th>
                        <th>Deskripsi</th>
                        <th>Umur Minimal (bulan)</th>
                        <th>Umur Maksimal (bulan)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahapanPerkembangan as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama_tahapan }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ $item->umur_minimal_bulan }}</td>
                            <td>{{ $item->umur_maksimal_bulan }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.tahapan_perkembangan.edit', $item->id) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.tahapan_perkembangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
