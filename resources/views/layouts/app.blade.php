
<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Bootstrap 5.3 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
    tailwind.config = {
        safelist: ['bg-[#005f77]', 'hover:bg-[#014f66]']
    }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>


    {{-- Custom Styles --}}
    <style>
        body {
            padding-top: 60px;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            height: 56px;
        }

        .navbar-brand {
            font-weight: 600;
            color: #005f77 !important;
        }

        main.container {
            max-width: 1280px;
        }

        .content-card {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg px-4"> {{-- gunakan padding --}}
        <div class="d-flex w-100 justify-content-between align-items-center">
            <a class="navbar-brand" href="#">Dashboard</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @elseif(Auth::user()->role === 'orangtua')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orangtua.dashboard') }}">Orangtua Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mt-4">
        <div class="content-card">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>