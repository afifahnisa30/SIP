<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SIP - Salam Indah Post</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css') }}" />
    <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<script>
window.addEventListener("scroll", function () {
    const navbar = document.getElementById("mainNavbar");
    navbar.classList.toggle("scrolled", window.scrollY > 50);
});
</script>

<body>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top px-4 px-lg-5" id="mainNavbar">
    <!-- Logo -->
    <a href="#" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('assets/img/logo.png')}}" 
            style="width: 45px; height: 45px; object-fit: contain; margin-right: 10px;" alt="">
        <h2 class="m-0 fw-bold text-primary">SIP</h2>
    </a>
    <!-- Hamburger -->
    <button type="button" class="navbar-toggler shadow-none border-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <i class="fas fa-bars text-white fs-4" id="menuIcon"></i>
    </button>
    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-4 py-lg-0">
            <a href="#" class="nav-item nav-link active nav-custom">Beranda</a>
            <a href="#tentang" class="nav-item nav-link nav-custom">Tentang</a>
            <a href="#produk" class="nav-item nav-link nav-custom">Produk</a>
            <a href="#alur" class="nav-item nav-link nav-custom">Alur Pesan</a>
            <a href="#kontak" class="nav-item nav-link nav-custom">Kontak</a>
        </div>
        
        <!-- Dinamis Button Berdasarkan Status Login Jetstream -->
        <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 ms-lg-4">
            @if (Route::has('login'))
                @auth
                    <!-- Jika User Sudah Login -->
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                        Dashboard
                    </a>
                @else
                    <!-- Jika User Belum Login -->
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">
                            Daftar
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>
<!-- Navbar End -->

<!-- HERO SECTION -->
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h5 class="text-warning text-uppercase fw-bold mb-3 animate__animated animate__fadeInDown">
            Selamat Datang di Percetakan Salam Indah
        </h5>
        <h1 class="hero-title mb-4 animate__animated animate__fadeInUp">
            Cetak Cepat, Murah <br> & Hasil Berkualitas
        </h1>
        <p class="hero-text mb-5 animate__animated animate__fadeInUp">
            Solusi pemesanan produk percetakan online untuk spanduk, banner, brosur, undangan, stiker, dan berbagai kebutuhan cetak lainnya .
        </p>
        
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-orange animate__animated animate__fadeInUp">
                Mulai Pemesanan
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-orange animate__animated animate__fadeInUp">
                Pesan Sekarang
            </a>
        @endauth
    </div>
</div>
<!-- HERO SECTION END -->

<!-- Tentang Start -->
<div id="tentang" class="container-fluid faq-section bg-light py-4">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="h-100">
                    <div class="mb-5">
                        <h1 class="display-4 mb-0">Apa itu SIP?</h1>
                    </div>
                    <p class="mb-4 fs-5">
                        <strong>SIP (Salam Indah Post)</strong> merupakan sistem informasi pemesanan produk percetakan berbasis website pada Percetakan Salam Indah yang dirancang untuk mempermudah pelanggan dalam melakukan pemesanan berbagai kebutuhan percetakan secara online dengan cepat, praktis, dan efisien.
                    </p>
                    <h3 class="text-primary">Keunggulan SIP</h3>
                    <ul class="list-unstyled fs-5 mt-3 text-start d-inline-block">
                        <li class="mb-2">✅ Pemesanan produk dapat dilakukan secara online</li>
                        <li class="mb-2">✅ Proses pemesanan lebih cepat dan praktis</li>
                        <li class="mb-2">✅ Menyediakan berbagai layanan percetakan berkualitas</li>
                        <li class="mb-2">✅ Mempermudah pelanggan dalam melihat informasi produk</li>
                        <li class="mb-2">✅ Dapat digunakan dimana saja dan kapan saja</li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                <img src="{{ asset('assets/img/mesin.png') }}" class="img-fluid w-80" alt="Ilustrasi Mesin">
            </div>
        </div>
    </div>
</div>
<!-- Tentang End -->

<!-- Katalog Produk Start -->
<div class="container py-5" id="produk">
     <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h1 class="display-5 text-primary mb-2">Layanan Produk</h1>
            <h4 class="mb-0">Menyediakan berbagai produk percetakan berkualitas sesuai kebutuhan Anda</h4>
        </div>
    <div id="produkCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row justify-content-center g-4">
                    <div class="col-6 col-md-4 col-lg-2 text-center d-flex justify-content-center">
                        <div class="product-item">
                            <img src="{{ asset('assets/img/spanduk.png') }}" class="img-fluid product-image" alt="Spanduk">
                            <h5 class="mt-4">Spanduk</h5>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 text-center d-flex justify-content-center">
                        <div class="product-item">
                            <img src="{{ asset('assets/img/banner.png') }}" class="img-fluid product-image" alt="Banner">
                            <h5 class="mt-4">Banner</h5>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 text-center d-flex justify-content-center">
                        <div class="product-item">
                            <img src="{{ asset('assets/img/stiker.png') }}" class="img-fluid product-image" alt="Stiker">
                            <h5 class="mt-4">Stiker</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row justify-content-center g-4">
                    <div class="col-6 col-md-4 col-lg-2 text-center d-flex justify-content-center">
                        <div class="product-item">
                            <img src="{{ asset('assets/img/kartu_nama.png') }}" class="img-fluid product-image" alt="Kartu Nama">
                            <h5 class="mt-4">Kartu Nama</h5>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 text-center d-flex justify-content-center">
                        <div class="product-item">
                            <img src="{{ asset('assets/img/buku_nota.png') }}" class="img-fluid product-image" alt="Buku Nota">
                            <h5 class="mt-4">Buku Nota</h5>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 text-center d-flex justify-content-center">
                        <div class="product-item">
                            <img src="{{ asset('assets/img/brosur.png') }}" class="img-fluid product-image" alt="Brosur">
                            <h5 class="mt-4">Brosur</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#produkCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#produkCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
        </button>
    </div>
</div>
<!-- Katalog Produk End -->

<!-- Feature Start -->
<div class="container-fluid feature bg-light py-3" id="alur">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Alur Pemesanan</h4>
            <h1 class="display-5 mb-4">Pesan Produk Jadi Lebih Mudah</h1>
            <p class="mb-0">
                Nikmati proses pemesanan produk percetakan secara online dengan langkah yang praktis, mulai dari memilih produk, mengunggah desain, hingga proses pengambilan pesanan.
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-2 wow fadeInUp" data-wow-delay="0.2s">
                <div class="feature-item p-4 pt-0 text-center h-100">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-user-plus fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Registrasi Akun</h4>
                    <p class="mb-0">Pelanggan dapat membuat akun dan login ke dalam sistem dengan mudah.</p>
                </div>
            </div>
            <div class="col-md-2 wow fadeInUp" data-wow-delay="0.3s">
                <div class="feature-item p-4 pt-0 text-center h-100">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-print fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Pilih Produk</h4>
                    <p class="mb-0">Pelanggan dapat memilih berbagai produk percetakan sesuai kebutuhan.</p>
                </div>
            </div>
            <div class="col-md-2 wow fadeInUp" data-wow-delay="0.4s">
                <div class="feature-item p-4 pt-0 text-center h-100">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-pen-to-square fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Isi Detail Pesanan</h4>
                    <p class="mb-0">Isi ukuran, jumlah, jenis bahan, dan detail produk yang ingin dicetak.</p>
                </div>
            </div>
            <div class="col-md-2 wow fadeInUp" data-wow-delay="0.5s">
                <div class="feature-item p-4 pt-0 text-center h-100">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-upload fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Upload Desain</h4>
                    <p class="mb-0">Upload file desain secara langsung melalui website percetakan.</p>
                </div>
            </div>
            <div class="col-md-2 wow fadeInUp" data-wow-delay="0.6s">
                <div class="feature-item p-4 pt-0 text-center h-100">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-gears fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Proses Cetak</h4>
                    <p class="mb-0">Admin memeriksa dan memproses pesanan pelanggan untuk dicetak.</p>
                </div>
            </div>
            <div class="col-md-2 wow fadeInUp" data-wow-delay="0.7s">
                <div class="feature-item p-4 pt-0 text-center h-100">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-box-open fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Pengambilan Pesanan</h4>
                    <p class="mb-0">Pesanan yang selesai dicetak dapat diambil langsung oleh pelanggan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

<!-- Kontak Start -->
<div class="container-fluid py-5 bg-light" id="kontak">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h1 class="display-5 text-primary mb-2">Kontak Kami</h1>
            <h4 class="mb-0">Hubungi kami atau kunjungi lokasi percetakan secara langsung</h4>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="bg-white rounded p-4 shadow-sm h-100">
                    <h4 class="mb-4">Informasi Percetakan</h4>
                    <p><i class="fa fa-map-marker-alt text-primary me-3"></i> Hative Kecil, Kec. Sirimau, Kota Ambon, Maluku</p>
                    <p><i class="fa fa-phone-alt text-primary me-3"></i> +62 821-8934-6164</p>
                    <p><i class="fa fa-envelope text-primary me-3"></i> cetaksalamindah2@gmail.com</p>
                    <p><i class="fa fa-clock text-primary me-3"></i> Senin - Sabtu : 09.00 - 21.00 WIT</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="rounded overflow-hidden shadow-sm">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.632588946095!2d128.1993215!3d-3.6708285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d6ce9183fe756f9%3A0xccb565d6e352d014!2sPercetakan%20Salam%20Indah%202!5e0!3m2!1sid!2sid!4v1779121199855!5m2!1sid!2sid"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Kontak End -->

<!-- Footer -->
    <footer class="bg-white border-top py-4 text-center text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} Percetakan Salam Indah - SIP (Salam Indah Post). All rights reserved.
        </div>
    </footer>

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>
<script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>