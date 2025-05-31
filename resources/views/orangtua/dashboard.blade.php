@extends('layouts.app')

@section('content')

<style>
    /* OVERRIDE agar container bawaan layout jadi full width hanya untuk halaman ini */
    .container.mt-4 {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .section-wrapper {
        padding-inline: 5%;
    }

    .section-title {
        color: #005f77;
        font-weight: 700;
        font-size: 3rem;
    }

    .section-title-feature {
        color: #005f77;
        font-weight: 700;
        font-size: 2rem;
    }

    .hero-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 60px 0;
        /* background-color: #f8f9fa; */
    }

    .hero-text {
        max-width: 55%;
    }

    .hero-image {
        width: 45%;
        height: 450px; /* bisa ubah jadi 400px kalau masih kurang besar */
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .hero-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }



    .feature-grid {
        display: flex;
        gap: 20px;
        padding: 40px 0;
    }

    .feature-box {
    background-color: #005f77;
    color: white;
    flex: 1;
    padding: 20px;
    border-radius: 12px;
    transition: 0.2s ease-in-out;
}

    .feature-box h3 {
        color: #ffffff;
    }

    .feature-box p {
        color: #f1f1f1;
    }

    .icon-feature {
        font-size: 2rem;
        color: #ffffff;
        margin-bottom: 10px;
        display: block;
    }


    .menu-grid,
    .article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); /* dari 220px jadi 300px */
        gap: 28px; /* sedikit lebih besar */
        padding-bottom: 40px;
        padding-top: 20px;
    }

    .menu-block {
        background: #f1f1f1;
        padding: 28px;
        border-radius: 16px;
        text-align: center;
        min-height: 380px; /* 👉 tambah tinggi minimum */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .menu-block img {
        width: 100%;
        height: 200px; /* lebih tinggi */
        object-fit: contain;
        border-radius: 10px;
    }
    
    .article-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 380px; /* 👉 tambah tinggi minimum */
        justify-content: space-between;
    }

    .article-card img {
        width: 100%;
        height: 200px; /* lebih tinggi */
        object-fit: contain;
    }

    .article-content {
        padding: 15px;
    }

    .article-actions {
        display: flex;
        justify-content: space-between;
        padding: 0 15px 15px;
        font-size: 0.9rem;
        color: gray;
    }

    .section-header {
        padding: 20px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }
    
    .btn btn-primary {
        background-color: #005f77;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
        text-decoration: none;
    }

    .feature-box-link {
    flex: 1;
    text-decoration: none;
    transition: transform 0.2s ease-in-out;
}

    .feature-box-link:hover {
        transform: translateY(-6px);
    }

    .feature-box {
        background-color: #005f77;
        color: white;
        padding: 20px;
        border-radius: 12px;
        height: 100%;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        display: block;
    }

    .feature-box:hover {
        background-color: #00485e;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .feature-box h3,
    .feature-box p {
        color: white;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        top: 40%;
        bottom: auto;
        opacity: 1;
        transition: 0.3s;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.4);
        background-size: 60% 60%;
        border-radius: 50%;
        padding: 10px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: transparent;
        opacity: 0.8;
        transform: scale(1.1);
    }

    #articleCarousel .carousel-control-prev,
    #articleCarousel .carousel-control-next {
        width: 5%;
        top: 40%;
        bottom: auto;
        opacity: 1;
        transition: 0.3s;
    }

    #articleCarousel .carousel-control-prev-icon,
    #articleCarousel .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.4);
        background-size: 60% 60%;
        border-radius: 50%;
        padding: 10px;
    }

    #articleCarousel .carousel-control-prev:hover,
    #articleCarousel .carousel-control-next:hover {
        background-color: transparent;
        opacity: 0.8;
        transform: scale(1.1);
    }

    .carousel-control-prev,
    .carousel-control-next {
        z-index: 10;
    }

    .carousel {
    position: relative;
}


</style>

<div class="section-wrapper">

    {{-- HERO SECTION --}}
    <div class="hero-section">
        <div class="hero-text">
            <h2 class="section-title">Pantau Tumbuh Kembang, Cegah Stunting Sejak Dini!</h2>
            <p>Pantau dan deteksi tumbuh kembang anak Anda secara berkala, serta dapatkan rekomendasi menu bergizi yang disesuaikan dengan kebutuhan hariannya untuk mendukung pertumbuhan yang optimal.</p>
            <div class="mt-3">
                <a href="{{ route('orangtua.detections.create') }}" class="btn btn-primary" style="background-color: #005f77; border: none;">Deteksi Stunting</a>
                <a href="{{ route('orangtua.tahapan_perkembangan.index') }}" class="btn btn-primary" style="background-color: #005f77; border: none;">Monitoring Anak</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/logo.png') }}" alt="Ilustrasi Dashboard" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
    </div>

    {{-- FITUR UTAMA --}}
    <div class="feature-grid">
        <a href="{{ route('orangtua.immunization_records.index') }}" class="feature-box-link">
            <div class="feature-box">
                <i class="fas fa-syringe icon-feature"></i>
                <h3>Immunization</h3>
                <p>Cek dan pantau riwayat imunisasi anak Anda dengan mudah dan cepat.</p>
            </div>
        </a>
        <a href="{{ route('orangtua.detections.create') }}" class="feature-box-link">
            <div class="feature-box">
                <i class="fas fa-magnifying-glass icon-feature"></i>
                <h3>Deteksi</h3>
                <p>Deteksi stunting pada anak dengan menggunakan metode yang tepat.</p>
            </div>
        </a>
        <a href="{{ route('bmi') }}" class="feature-box-link">
            <div class="feature-box">
                <i class="fas fa-weight icon-feature"></i>
                <h3>BMI</h3>
                <p>Hitung status gizi anak secara cepat dan mudah berdasarkan tinggi dan berat badan.</p>
            </div>
        </a>
    </div>



    {{-- TODAY MENU --}}
    <div class="section-header">
        <h4 class="section-title-feature mb-0">Today Menu’s</h4>
        <a href="{{ route('orangtua.nutritionUs.index') }}" class="btn btn-sm btn-light border rounded-circle" title="Lihat semua menu">
            <i class="fas fa-arrow-right text-dark"></i>
        </a>
    </div>

    <div id="menuCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
        <div class="carousel-inner">

            @foreach (collect(['pagi', 'siang', 'malam', 'snack'])->chunk(3) as $chunked)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunked as $waktu)
                            @if ($menus[$waktu])
                                <div class="col-md-4">
                                    <div class="menu-block mb-4">
                                        <img src="{{ $menus[$waktu]->image ? asset('storage/' . $menus[$waktu]->image) : asset('default-image.png') }}" alt="Menu" style="width:100%; height:150px; object-fit:contain; border-radius:8px;">
                                        <h6 class="mt-2">{{ $menus[$waktu]->name }}</h6>
                                        <small class="text-muted">{{ ucfirst($menus[$waktu]->category) }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('orangtua.nutritionUs.show', $menus[$waktu]->id) }}" 
                                            style="background:#005f77; color:white; border-radius:8px; padding:8px 18px; text-decoration:none; font-size:0.95rem; display:inline-block;">
                                                Lihat Menu
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Navigasi Carousel --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>


    {{-- ARTICLES --}}
    <div class="section-header">
        <h4 class="section-title-feature mb-0">Articles</h4>
        <a href="{{ route('orangtua.artikel.index') }}" class="btn btn-sm btn-light border rounded-circle" title="Lihat semua artikel">
            <i class="fas fa-arrow-right text-dark"></i>
        </a>
    </div>

    <div id="articleCarousel" class="carousel slide position-relative" data-bs-ride="false" data-bs-interval="false">
        <div class="carousel-inner">
            @foreach ($artikels->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $artikel)
                            <div class="col-md-4">
                                <div class="article-card mb-4">
                                    <img src="{{ $artikel->image ? asset('storage/' . $artikel->image) : asset('default-image.png') }}" alt="Artikel" >
                                    <div class="article-content">
                                        <p>{{ Str::limit($artikel->title, 80) }}</p>
                                    </div>
                                    <div class="article-actions">
                                        <span>👁 {{ $artikel->views ?? 0 }}</span>
                                        <a href="{{ route('orangtua.artikel.show', $artikel->id) }}">Read All</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tombol Panah --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#articleCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#articleCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
@endsection
