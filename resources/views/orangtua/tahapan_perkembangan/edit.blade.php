<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pencapaian Tahapan Perkembangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6c757d;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('orangtua.tahapan_perkembangan.index') }}">Orangtua Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Edit Pencapaian Tahapan Perkembangan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.tahapan_perkembangan.update', $tahapanPerkembanganData->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="tahapan_perkembangan_id" class="form-label">Pilih Tahapan Perkembangan</label>
                        <select class="form-select" name="tahapan_perkembangan_id" id="tahapan_perkembangan_id" required>
                            @foreach($tahapanPerkembangan as $tahapan)
                                <option value="{{ $tahapan->id }}" {{ $tahapan->id == $tahapanPerkembanganData->tahapan_perkembangan_id ? 'selected' : '' }}>
                                    {{ $tahapan->nama_tahapan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pencapaian" class="form-label">Tanggal Pencapaian</label>
                        <input type="date" class="form-control" name="tanggal_pencapaian" id="tanggal_pencapaian" 
                            value="{{ old('tanggal_pencapaian', $tahapanPerkembanganData->tanggal_pencapaian) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="tercapai" {{ $tahapanPerkembanganData->status == 'tercapai' ? 'selected' : '' }}>Tercapai</option>
                            <option value="belum_tercapai" {{ $tahapanPerkembanganData->status == 'belum_tercapai' ? 'selected' : '' }}>Belum Tercapai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" id="catatan" rows="3">{{ old('catatan', $tahapanPerkembanganData->catatan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('orangtua.tahapan_perkembangan.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar</a>
                        <button type="submit" class="btn btn-secondary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
