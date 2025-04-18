<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Deteksi Stunting (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Data Deteksi Stunting (Admin)</h2>

    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur (bulan)</th>
                <th>Jenis Kelamin</th>
                <th>Berat Badan (kg)</th>
                <th>Tinggi Badan (cm)</th>
                <th>Z-Score</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($detections as $d)
                <tr>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->umur }}</td>
                    <td>{{ $d->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $d->berat_badan }}</td>
                    <td>{{ $d->tinggi_badan }}</td>
                    <td>{{ $d->z_score }}</td>
                    <td>
                        <span class="badge 
                            {{ $d->status == 'Stunting' ? 'bg-danger' : ($d->status == 'Normal' ? 'bg-success' : 'bg-warning') }}">
                            {{ $d->status }}
                        </span>
                    </td>
                    <td>{{ $d->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data deteksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
