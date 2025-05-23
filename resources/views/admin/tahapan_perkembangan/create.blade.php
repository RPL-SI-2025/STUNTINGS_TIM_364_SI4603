<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tahapan Perkembangan</title>
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
                        <a class="nav-link active" href="{{ route('admin.tahapan_perkembangan.create') }}">Tambah Tahapan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Tambah Tahapan Perkembangan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tahapan_perkembangan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_tahapan" class="form-label">Nama Tahapan</label>
                        <input type="text" class="form-control" name="nama_tahapan" id="nama_tahapan" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="umur_minimal_bulan" class="form-label">Umur Minimal (bulan)</label>
                            <input type="number" class="form-control" name="umur_minimal_bulan" id="umur_minimal_bulan">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="umur_maksimal_bulan" class="form-label">Umur Maksimal (bulan)</label>
                            <input type="number" class="form-control" name="umur_maksimal_bulan" id="umur_maksimal_bulan">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.tahapan_perkembangan.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-secondary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
