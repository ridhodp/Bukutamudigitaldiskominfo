<?php
include 'config/koneksi.php';
$query_tamu = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_tamu FROM tb_tamu");
$data_tamu = mysqli_fetch_assoc($query_tamu);
$jumlah_tamu = $data_tamu['jumlah_tamu'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Diskominfostaper Kabupaten Karimun</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/profilweb.css" rel="stylesheet">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/diskominfotbk.jpg" alt="Logo Staper">
                Diskominfostaper Kabupaten Karimun
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galery">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container text-center">
            <div class="hero-content">
                <h1 class="display-3 fw-bold mb-4 text-white animate-fade-in">Selamat Datang di Diskominfostaper Kabupaten Karimun</h1>
                <p class="lead mb-4 text-white-50 fs-4 animate-fade-in-delay">Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun</p>
                <p class="mb-5 fs-5 text-white animate-fade-in-delay-2">Menyediakan layanan komunikasi, informatika, statistik, dan persandian untuk mendukung pembangunan daerah dan pelayanan masyarakat</p>
                <div class="hero-buttons animate-fade-in-delay-3">
                    <a href="#layanan" class="btn btn-light btn-lg me-3">Lihat Layanan</a>
                    <a href="#kontak" class="btn btn-outline-light btn-lg">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Profil Section -->
    <section id="profil" class="py-5 bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4 text-white">Profil Dinas Komunikasi Informatika Statistik dan Persandian</h2>
                    <p class="lead text-white">Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun adalah instansi pemerintah yang bertugas dalam bidang komunikasi, informatika, statistik, dan persandian untuk mendukung pembangunan daerah.</p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-building text-primary me-2"></i>Tentang Kami</h5>
                            <p>Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun merupakan unsur pelaksana otonomi daerah yang membantu Bupati dalam melaksanakan urusan pemerintahan daerah di bidang komunikasi dan informatika.</p>
                            <p>Kami berkomitmen untuk memberikan pelayanan prima dalam pengelolaan informasi, komunikasi, statistik, dan keamanan data untuk masyarakat Kabupaten Karimun.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users text-success me-2"></i>Visi & Misi</h5>
                            <p><strong>Visi:</strong> Terwujudnya tata kelola komunikasi, informatika, statistik, dan persandian yang handal untuk mendukung pembangunan daerah yang berkualitas.</p>
                            <p><strong>Misi:</strong> Memberikan layanan komunikasi, informatika, statistik, dan persandian yang profesional, inovatif, dan terpercaya untuk kemajuan Kabupaten Karimun.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-tasks text-info me-2"></i>Fungsi Utama</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Penyusunan kebijakan teknis komunikasi dan informatika</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Pengelolaan sistem informasi pemerintah daerah</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Penyediaan data dan informasi statistik</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Pengamanan informasi dan persandian</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Pengembangan infrastruktur TIK</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Layanan komunikasi publik</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Koordinasi kegiatan antar perangkat daerah</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Pembinaan dan pengawasan teknis</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    <section id="layanan" class="py-5 bg-primary">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white">Layanan Yang Diberikan</h2>
                <p class="lead text-white-50">Layanan yang kami berikan untuk masyarakat dan instansi berdasarkan bidang</p>
            </div>
            <div class="row g-4">
                <!-- Bidang Sekretariat & Umum -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-building fa-3x text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Bidang Sekretariat & Umum</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Administrasi dan Tata Usaha</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manajemen Kepegawaian</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengelolaan Keuangan</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengelolaan Aset dan Barang</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Layanan Umum dan Protokol</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Bidang Pengelolaan & Layanan Informasi Publik -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                            <h5 class="card-title fw-bold">Bidang Pengelolaan & Layanan Informasi Publik</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengelolaan Informasi Publik</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Layanan Informasi dan Dokumentasi</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengarsipan dan Klasifikasi Dokumen</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Layanan Permintaan Informasi Publik</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengembangan Sistem Informasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Bidang Komunikasi Publik dan Kehumasan -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-bullhorn fa-3x text-warning mb-3"></i>
                            <h5 class="card-title fw-bold">Bidang Komunikasi Publik dan Kehumasan</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Komunikasi Publik dan Media Relations</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengembangan Konten dan Publikasi</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manajemen Media Sosial</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Event dan Konferensi Pers</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hubungan Masyarakat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 justify-content-center mt-4">
                <!-- Bidang TIK -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-laptop fa-3x text-danger mb-3"></i>
                            <h5 class="card-title fw-bold">Bidang TIK</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengembangan Sistem Informasi</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manajemen Data dan Basis Data</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengembangan Aplikasi</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Infrastruktur Teknologi Informasi</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pelatihan dan Edukasi Digital</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Dukungan Teknologi untuk Pemerintah</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Bidang Statistik & Persandian -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-secondary mb-3"></i>
                            <h5 class="card-title fw-bold">Bidang Statistik & Persandian</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Penyusunan Data Statistik Daerah</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Analisis Data untuk Perencanaan</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Publikasi Statistik</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Konsultasi Statistik</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Keamanan Informasi dan Data</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Enkripsi dan Dekripsi Data</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Perlindungan Rahasia Negara</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Audit Keamanan Sistem</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Konsultasi TTE</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manajemen Risiko Informasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galery Section -->
    <section id="galery" class="py-5 bg-primary">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white">Galeri</h2>
                <p class="lead text-white-50">Dokumentasi Kegiatan Diskominfostaper Kabupaten Karimun</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 gallery-card">
                        <div class="card-img-wrapper">
                            <img src="img/dokumentasidiskominfo1.jpeg" class="card-img-top" alt="dokumentasi 1">
                            <div class="card-img-overlay">
                                <i class="fas fa-search-plus overlay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 gallery-card">
                        <div class="card-img-wrapper">
                            <img src="img/dokumentasidiskominfo2.jpeg" class="card-img-top" alt="dokumentasi 2">
                            <div class="card-img-overlay">
                                <i class="fas fa-search-plus overlay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 gallery-card">
                        <div class="card-img-wrapper">
                            <img src="img/dokumentasidiskominfo3.jpeg" class="card-img-top" alt="dokumentasi 3">
                            <div class="card-img-overlay">
                                <i class="fas fa-search-plus overlay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 gallery-card">
                        <div class="card-img-wrapper">
                            <img src="img/dokumentasidiskominfo4.jpeg" class="card-img-top" alt="dokumentasi 4">
                            <div class="card-img-overlay">
                                <i class="fas fa-search-plus overlay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 gallery-card">
                        <div class="card-img-wrapper">
                            <img src="img/dokumentasidiskominfo5.jpeg" class="card-img-top" alt="dokumentasi 5">
                            <div class="card-img-overlay">
                                <i class="fas fa-search-plus overlay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 gallery-card">
                        <div class="card-img-wrapper">
                            <img src="img/dokumentasidiskominfo6.jpeg" class="card-img-top" alt="dokumentasi 6">
                            <div class="card-img-overlay">
                                <i class="fas fa-search-plus overlay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-5 bg-primary">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white">Informasi Kontak</h2>
                <p class="lead text-white-50">Hubungi kami untuk informasi lebih lanjut</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-map-marker-alt fa-lg"></i>
                                </div>
                                <h5 class="card-title mb-0 fw-bold">Alamat Kantor</h5>
                            </div>
                            <p class="card-text mb-0">Jl. Jend. Sudirman, Poros RT 004 RW 001<br>Kelurahan Darussaalam, Kecamatan Meral Barat, Kabupaten Karimun<br>Provinsi Kepulauan Riau</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-phone fa-lg"></i>
                                </div>
                                <h5 class="card-title mb-0 fw-bold">Kontak</h5>
                            </div>
                            <p class="card-text mb-0">
                                <strong>Telepon:</strong> +628 123 456 789<br>
                                <strong>Email:</strong> diskominfostaperkarimun@gmail.com<br>
                                <strong>Website Informasi:</strong> <a href="https://diskominfostaper.karimunkab.go.id" target="_blank" class="text-decoration-none">diskominfostaper.karimunkab.go.id</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-6 mb-4">
                    <div class="footer-logo mb-3">
                        <img src="img/diskominfotbk.jpg" alt="Logo" class="img-fluid rounded-circle shadow" style="max-width: 80px; border: 3px solid rgba(255,255,255,0.3);">
                    </div>
                    <h5 class="fw-bold mb-3">Diskominfostaper Kabupaten Karimun</h5>
                    <p class="mb-0 opacity-75">Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun</p>
                </div>
                <div class="col-lg-6 mb-4">
                    <h5 class="fw-bold mb-4">Media Sosial Kami</h5>
                    <div class="social-links d-flex justify-content-center mb-3">
                        <a href="https://www.instagram.com/diskominfo_karimun/" class="text-white me-4" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@DiskominfoKarimun" class="text-white" target="_blank" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <p class="mb-0 opacity-75">Dapatkan informasi terbaru melalui media sosial kami</p>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="text-center">
                <p class="mb-2 opacity-75">&copy; 2025 Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Loading Screen -->
    <div id="loading" class="loading">
        <div class="spinner"></div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loading screen
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            setTimeout(() => {
                loading.classList.add('hidden');
            }, 500);
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                // Remove active class from all nav links
                document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                    link.classList.remove('active');
                });

                // Add active class to clicked link
                this.classList.add('active');

                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for fade-in animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Add fade-in class to sections
        document.querySelectorAll('section').forEach(section => {
            section.classList.add('fade-in');
            observer.observe(section);
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });


        // Gallery hover effect enhancement
        document.querySelectorAll('.gallery-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.scrollY;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
            }
        });
    </script>
</body>
</html>
