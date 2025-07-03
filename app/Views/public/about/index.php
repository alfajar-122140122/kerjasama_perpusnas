<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Tugas Pokok dan Fungsi Tim Kerjasama</h2>
            
            <div class="card">
                <div class="card-body">
                    <?php if(isset($about) && $about): ?>
                        <?= $about['content'] ?>
                    <?php else: ?>
                    <div class="about-content">
                        <h3>Tugas Pokok</h3>
                        <p>Tim Kerjasama Perpustakaan Nasional memiliki tugas pokok untuk mengkoordinasikan, mengembangkan, dan mengevaluasi seluruh aktivitas kerjasama Perpustakaan Nasional dengan berbagai pihak, baik institusi pemerintah, swasta, maupun perguruan tinggi, baik dalam lingkup nasional maupun internasional.</p>
                        
                        <h3>Fungsi</h3>
                        <ul>
                            <li>Menyusun dan mengembangkan kebijakan dan strategi kerjasama Perpustakaan Nasional</li>
                            <li>Mengidentifikasi dan menganalisis potensi kerjasama yang dapat dijalin dengan berbagai pihak</li>
                            <li>Memfasilitasi proses pengusulan, perancangan, dan penandatanganan dokumen kerjasama</li>
                            <li>Melakukan monitoring dan evaluasi terhadap implementasi kerjasama yang telah disepakati</li>
                            <li>Menyelenggarakan kegiatan dalam rangka pengembangan kerjasama perpustakaan</li>
                            <li>Menyusun laporan perkembangan kerjasama secara berkala</li>
                            <li>Menjaga hubungan baik dengan seluruh mitra kerjasama Perpustakaan Nasional</li>
                        </ul>
                        
                        <h3>Bentuk Kerjasama</h3>
                        <p>Bentuk kerjasama yang dikelola oleh Tim Kerjasama meliputi:</p>
                        <ol>
                            <li>Kerjasama pengembangan koleksi perpustakaan</li>
                            <li>Kerjasama pertukaran tenaga ahli dan pustakawan</li>
                            <li>Kerjasama pengembangan sistem otomasi perpustakaan</li>
                            <li>Kerjasama pelestarian bahan pustaka</li>
                            <li>Kerjasama penelitian dan publikasi</li>
                            <li>Kerjasama pelatihan dan pengembangan SDM perpustakaan</li>
                            <li>Kerjasama promosi dan sosialisasi kegiatan perpustakaan</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
