<!DOCTYPE html>
<html>
<head>
    <title>Kerja Sama - Perpustakaan Nasional RI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .debug { background: #f0f0f0; padding: 20px; margin: 20px 0; }
        .menu-card { border: 1px solid #ddd; padding: 20px; margin: 10px 0; display: block; text-decoration: none; color: #333; }
        .menu-card:hover { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Portal Kerja Sama - DEBUG MODE</h1>
    
    <div class="debug">
        <h3>Debug Information:</h3>
        <p><strong>Current URI:</strong> <?= uri_string() ?></p>
        <p><strong>View File:</strong> app/Views/public/kerjasama/index.php</p>
        <p><strong>Controller:</strong> Public\KerjaSama::index()</p>
    </div>
    
    <h2>Menu Kerja Sama</h2>
    
    <a href="<?= base_url('kerja-sama/data') ?>" class="menu-card">
        <h3>📊 Data Kerja Sama</h3>
        <p>Data lengkap kerja sama perpustakaan</p>
    </a>
    
    <a href="<?= base_url('kerja-sama/implementasi') ?>" class="menu-card">
        <h3>🤝 Implementasi Kerja Sama</h3>
        <p>Status implementasi kerja sama aktif</p>
    </a>
    
    <a href="<?= base_url('kerja-sama/akan-berakhir') ?>" class="menu-card">
        <h3>⏰ Kerja Sama yang Akan Berakhir</h3>
        <p>Daftar kerja sama yang akan berakhir</p>
    </a>
    
    <a href="<?= base_url('kerja-sama/progress') ?>" class="menu-card">
        <h3>📈 Progress</h3>
        <p>Progress dan statistik kerja sama</p>
    </a>
    
    <a href="<?= base_url('kerja-sama/pengajuan') ?>" class="menu-card">
        <h3>📝 Pengajuan</h3>
        <p>Form pengajuan kerja sama baru</p>
    </a>
    
    <div class="debug">
        <h3>Quick Links:</h3>
        <ul>
            <li><a href="<?= base_url() ?>">Back to Home</a></li>
            <li><a href="<?= base_url('debug/routes') ?>">View All Routes</a></li>
        </ul>
    </div>
</body>
</html>