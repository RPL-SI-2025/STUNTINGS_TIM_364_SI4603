<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pencapaian Tahapan Perkembangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6c757d;">
        <div class="container">
            <a class="navbar-brand" href="#">Orangtua Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Daftar Pencapaian Tahapan Perkembangan</h4>
            </div>
            <div class="card-body">
                <div class="mb-3 text-end">
                    <a href="{{ route('orangtua.tahapan_perkembangan.create') }}" class="btn btn-secondary">Tambah Pencapaian</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-secondary">
                            <tr>
                                <th>Nama Tahapan</th>
                                <th>Tanggal Pencapaian</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tahapanPerkembanganData as $data)
                                <tr>
                                    <td>{{ $data->tahapanPerkembangan->nama_tahapan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_pencapaian)->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge {{ $data->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($data->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $data->catatan }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('orangtua.tahapan_perkembangan.edit', $data->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('orangtua.tahapan_perkembangan.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($tahapanPerkembanganData->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pencapaian yang tercatat.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
