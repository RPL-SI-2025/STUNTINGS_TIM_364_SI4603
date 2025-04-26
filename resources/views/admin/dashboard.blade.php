<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Halo</h1>

    <form action="{{ route('admin.detections.index') }}" method="get">
        <button type="submit" class="btn btn-primary">Cek Stunting</button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</body>
</html>
