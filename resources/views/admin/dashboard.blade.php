<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Halo</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
<a href="{{ route('admin.immunizations.index') }}" class="btn btn-primary">Cek Data Imunisasi</a>
<a href="{{ route('admin.tahapan_perkembangan.index') }}" class="btn btn-primary">Cek Data perkembangan</a>
    </form>
</body>
</html>
