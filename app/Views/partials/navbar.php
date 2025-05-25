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