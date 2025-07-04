<!-- Custom Header using Bootstrap utilities -->
<header class="home-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Logo Perpustakaan Nasional" class="img-fluid" style="width: 100px; height: 50px;">
                    </div>
                    <div class="text-white">
                        <h4 class="mb-0 fw-bold" style="font-size: 14px; line-height: 1.2;">KERJASAMA PERPUSTAKAAN</h4>
                        <p class="mb-0 opacity-75" style="font-size: 12px;">PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="d-flex justify-content-end align-items-center gap-3 flex-wrap">
                    <!-- Dropdown using Bootstrap -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle rounded-pill px-3 py-2" type="button" data-bs-toggle="dropdown" style="font-size: 14px;">
                            Situs ini
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('/') ?>">Portal Kerjasama</a></li>
                            <li><a class="dropdown-item" href="https://perpusnas.go.id" target="_blank">Website Utama</a></li>
                            <li><a class="dropdown-item" href="https://e-resources.perpusnas.go.id" target="_blank">E-Resources</a></li>
                            <li><a class="dropdown-item" href="https://koleksi.perpusnas.go.id" target="_blank">Koleksi Digital</a></li>
                        </ul>
                    </div>
                    <!-- Search using Bootstrap input group -->
                    <div class="position-relative">
                        <input type="text" class="form-control rounded-pill pe-5" placeholder="Cari" style="width: 250px; font-size: 14px;" id="headerSearchInput">
                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent" onclick="performHeaderSearch()">
                            <i class="fas fa-search text-muted"></i>
                        </button>
                    </div>
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-light rounded-pill px-3 py-2" style="font-size: 14px;">Login</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Navigation using Bootstrap nav -->
<nav class="home-nav">
    <div class="container">
        <ul class="nav nav-pills flex-nowrap overflow-auto">
            <li class="nav-item">
                <a class="nav-link <?= (current_url() == base_url('/')) ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'tentang') !== false) ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'aktivitas') !== false) ? 'active' : '' ?>" href="<?= base_url('aktivitas') ?>">Aktivitas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'kerja-sama') !== false) ? 'active' : '' ?>" href="<?= base_url('kerja-sama') ?>">Kerja Sama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'peta-kerja-sama') !== false) ? 'active' : '' ?>" href="<?= base_url('peta-kerja-sama') ?>">Peta Kerja Sama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'kontak') !== false) ? 'active' : '' ?>" href="<?= base_url('kontak') ?>">Kontak</a>
            </li>
        </ul>
    </div>
</nav>

<script>
// Header search functionality
function performHeaderSearch() {
    const searchInput = document.getElementById('headerSearchInput');
    const query = searchInput.value.trim();
    
    if (query) {
        // Redirect to search page with query parameter
        window.location.href = `${window.location.origin}/pencarian?q=${encodeURIComponent(query)}`;
    }
}

// Enter key search
document.getElementById('headerSearchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performHeaderSearch();
    }
});
</script>