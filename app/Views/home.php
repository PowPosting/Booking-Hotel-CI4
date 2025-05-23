<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Pemesanan Hotel Premium</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --light-color: #f3f4f6;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-color);
            background-color: #f8fafc;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #152b65;
            border-color: #152b65;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }
        
        .btn-accent:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: white;
        }
        
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= base_url('images/hero.jpg') ?>') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 150px 0;
            margin-top: -56px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 15px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        .room-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .room-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .feature-icon {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5 {
            color: var(--accent-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        footer ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        footer ul li {
            margin-bottom: 10px;
        }
        
        footer ul li a {
            color: #d1d5db;
            text-decoration: none;
        }
        
        footer ul li a:hover {
            color: white;
        }
        
        .social-icons a {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--accent-color);
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        
        .datepicker-container {
            position: relative;
        }
        
        .datepicker-container i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        /* Modal Styles */
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .modal-header .btn-close {
            color: white;
            box-shadow: none;
        }
        
        /* Auth Form Styles */
        .auth-form-container {
            position: fixed;
            top: 70px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: height 0.3s ease;
            z-index: 1050;
            display: none;
        }
        
        .auth-form-container.active {
            display: block;
        }
        
        .auth-forms {
            position: relative;
            width: 700px;
            display: flex;
            transition: transform 0.3s ease;
        }
        
        .auth-form {
            width: 350px;
            padding: 20px;
        }
        
        .auth-toggle {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .auth-header h4 {
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .password-field {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary-color);
            cursor: pointer;
            padding: 0;
            font-size: 16px;
        }
        
        /* Room Detail Styles */
        .room-gallery img {
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .room-gallery img:hover {
            opacity: 0.8;
        }
        
        .facility-item {
            margin-bottom: 15px;
        }
        
        .facility-item i {
            color: var(--accent-color);
            margin-right: 10px;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Samakan ukuran gambar di modal detail kamar */
        #roomDetailModal .modal-body img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-hotel me-2"></i>LuxStay</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rooms">Kamar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#facilities">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
                <?php $session = session(); ?>
                <div class="d-flex">
                    <?php if ($session->get('username')): ?>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-2"></i><?= htmlspecialchars($session->get('username')) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a href="<?= site_url('logout') ?>" class="dropdown-item">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <button class="btn btn-outline-primary" id="loginButton"><i class="fas fa-user me-2"></i>Akun</button>
    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-md-8 fade-in">
                    <h1 class="display-4 fw-bold mb-4">Nikmati Pengalaman Menginap Terbaik</h1>
                    <p class="lead mb-5">Temukan penginapan yang nyaman dan mewah dengan harga terbaik untuk perjalanan Anda</p>
                    <button class="btn btn-accent btn-lg px-4 py-2 shadow">Pesan Sekarang</button>
                </div>
            </div>
        </div>
    </section>

   
    <!-- Room Types Section -->
    <section id="rooms" class="py-5">
        <div class="container">
            <h2 class="section-title">Tipe Kamar</h2>
            <p class="text-muted mb-5">Pilih kamar yang sesuai dengan kebutuhan Anda</p>
            
            <div class="row g-4">
                <!-- Standard Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/Kamarstandar.jpg') ?>" class="card-img-top" alt="Standard Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Standard</h5>
                                <span class="badge bg-accent">Rp 800.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 Queen Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button
                                    class="btn btn-outline-primary btn-sm"
                                    onclick="showRoomDetail(
                                        'Kamar Standard',
                                        '<?= base_url('images/Kamarstandar.jpg') ?>',
                                        '<?= base_url('images/kamarstandar2.jpg') ?>',
                                        '<?= base_url('images/kamarmandistandar.jpg') ?>',
                                        'Nikmati kenyamanan maksimal di Kamar Standard kami, dilengkapi dengan fasilitas esensial yang dirancang untuk memberikan pengalaman menginap yang tenang dan menyenangkan. Cocok untuk pelancong solo maupun pasangan, kamar ini menghadirkan suasana hangat dan fungsional untuk istirahat yang berkualitas.',
                                        'Rp 800.000/malam'
                                    )"
                                    >Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="bookRoom('Kamar Standard')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deluxe Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamardeluxe.jpg') ?>" class="card-img-top" alt="Deluxe Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Deluxe</h5>
                                <span class="badge bg-accent">Rp 1.200.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar luas dengan pemandangan kota dan fasilitas lengkap.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 King Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail(
                                    'Kamar Deluxe',
                                    '/app/Views/src/images/kamardeluxe.jpg',
                                    'Kamar luas dengan pemandangan kota dan fasilitas lengkap.',
                                    'Rp 1.200.000/malam'
                                )">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="bookRoom('Kamar Deluxe')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Suite Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamarsuite.jpg') ?>" class="card-img-top" alt="Suite Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Suite Room</h5>
                                <span class="badge bg-accent">Rp 2.000.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 4 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 King Bed + Sofa Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Suite Room')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="bookRoom('Suite Room')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Family Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamarfamilyroom.jpg') ?>" class="card-img-top" alt="Family Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Keluarga</h5>
                                <span class="badge bg-accent">Rp 1.800.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 5 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 2 Queen Beds</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Keluarga')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="bookRoom('Kamar Keluarga')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Executive Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamareksekutif.jpg') ?>" class="card-img-top" alt="Executive Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Eksekutif</h5>
                                <span class="badge bg-accent">Rp 1.500.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 King Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Eksekutif')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="bookRoom('Kamar Eksekutif')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Penthouse -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamarpenthouse.jpg') ?>" class="card-img-top" alt="Penthouse">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Penthouse</h5>
                                <span class="badge bg-accent">Rp 3.500.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 6 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 2 King Beds</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Penthouse')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="bookRoom('Penthouse')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="facilities" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Fasilitas Hotel</h2>
            <p class="text-muted mb-5">Nikmati berbagai fasilitas premium selama menginap bersama kami</p>
            
            <div class="row g-4">
                <div class="col-md-4 text-center fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-swimming-pool"></i>
                    </div>
                    <h4>Kolam Renang</h4>
                    <p class="text-muted">Kolam renang infinity dengan pemandangan kota yang menakjubkan.</p>
                </div>
                
                <div class="col-md-4 text-center fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h4>Restoran</h4>
                    <p class="text-muted">Restoran bintang 5 dengan berbagai menu lokal dan internasional.</p>
                </div>
                
                <div class="col-md-4 text-center fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h4>Spa</h4>
                    <p class="text-muted">Nikmati perawatan spa tradisional dan modern untuk relaksasi Anda.</p>
                </div>
                
                <div class="col-md-4 text-center fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h4>Fitness Center</h4>
                    <p class="text-muted">Pusat kebugaran lengkap dengan peralatan modern 24 jam.</p>
                </div>
                
                <div class="col-md-4 text-center fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <h4>Wi-Fi Gratis</h4>
                    <p class="text-muted">Koneksi internet cepat di seluruh area hotel.</p>
                </div>
                
                <div class="col-md-4 text-center fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h4>Layanan Kamar 24 Jam</h4>
                    <p class="text-muted">Pelayanan kamar premium sepanjang hari.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Testimonial</h2>
            <p class="text-muted mb-5">Apa kata mereka tentang pengalaman menginap di hotel kami</p>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="/api/placeholder/150/150" class="testimonial-img me-3" alt="Customer 1">
                            <div>
                                <h5 class="mb-0">Ahmad Rizki</h5>
                                <small class="text-muted">Jakarta</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-0">"Pengalaman menginap yang luar biasa! Kamar yang nyaman, staf yang ramah, dan fasilitas yang lengkap. Sangat direkomendasikan!"</p>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="/api/placeholder/150/150" class="testimonial-img me-3" alt="Customer 2">
                            <div>
                                <h5 class="mb-0">Siti Nurul</h5>
                                <small class="text-muted">Surabaya</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="mb-0">"Saya sangat puas dengan pelayanan di hotel ini. Makanan di restoran juga lezat. Pasti akan kembali lagi!"</p>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="/api/placeholder/150/150" class="testimonial-img me-3" alt="Customer 3">
                            <div>
                                <h5 class="mb-0">Budi Santoso</h5>
                                <small class="text-muted">Bandung</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-0">"Lokasi strategis, kamar yang bersih dan nyaman. Pemandangan dari kolam renang juga menakjubkan. Tidak sabar untuk kembali!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Tentang LuxStay</h2>
                    <p>LuxStay adalah hotel bintang 5 yang berlokasi strategis di pusat kota. Kami berkomitmen untuk memberikan pengalaman menginap terbaik dengan fasilitas premium dan pelayanan yang ramah.</p>
                    <p>Sejak didirikan pada tahun 2010, LuxStay telah menjadi tujuan favorit bagi para pelancong bisnis maupun liburan. Dengan 200 kamar mewah dan berbagai fasilitas unggulan, kami siap membuat setiap kunjungan Anda berkesan.</p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-primary me-2">Selengkapnya</a>
                        <a href="#contact" class="btn btn-primary">Hubungi Kami</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <img src="/api/placeholder/600/400" alt="Hotel Exterior" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="section-title">Hubungi Kami</h2>
            <p class="text-muted mb-5">Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan</p>
            
            <div class="row">
                <div class="col-lg-6">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <h5>Alamat</h5>
                    <p>Jl. Raya LuxStay No. 123, Jakarta, Indonesia</p>
                    <h5>Telepon</h5>
                    <p>+62 21 1234 5678</p>
                    <h5>Email</h5>
                    <p>
                        <a href="mailto:info@luxstay.com">info@luxstay.com</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>

<footer class="bg-dark text-light py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; 2025 LuxStay. All rights reserved.</p>
    </div>
</footer>

<!-- Modal Detail Kamar -->
<div class="modal fade" id="roomDetailModal" tabindex="-1" aria-labelledby="roomDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roomDetailModalLabel">Detail Kamar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-4">
            <img id="modalRoomImg1" src="" alt="Room Image 1" class="img-fluid rounded" />
          </div>
          <div class="col-4">
            <img id="modalRoomImg2" src="" alt="Room Image 2" class="img-fluid rounded" />
          </div>
          <div class="col-4">
            <img id="modalRoomImg3" src="" alt="Room Image 3" class="img-fluid rounded" />
          </div>
        </div>
        <h4 id="modalRoomTitle"></h4>
        <p id="modalRoomDesc"></p>
        <span class="badge bg-accent mb-2" id="modalRoomPrice"></span>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('loginButton').addEventListener('click', function() {
        window.location.href = '<?= site_url('login') ?>';
    });

    function showRoomDetail(title, img1, img2, img3, desc, price) {
        document.getElementById('modalRoomTitle').textContent = title;
        document.getElementById('modalRoomImg1').src = img1;
        document.getElementById('modalRoomImg2').src = img2;
        document.getElementById('modalRoomImg3').src = img3;
        document.getElementById('modalRoomDesc').textContent = desc;
        document.getElementById('modalRoomPrice').textContent = price;
        var myModal = new bootstrap.Modal(document.getElementById('roomDetailModal'));
        myModal.show();
    }
</script>
</body>
</html>