<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= $page_title ?> - Perpustakaan Nasional RI<?= $this->endSection() ?>

<?= $this->section('description') ?><?= $meta_description ?><?= $this->endSection() ?>

<?= $this->section('keywords') ?>permohonan kerja sama, pengajuan kerjasama, formulir kerjasama, perpustakaan nasional<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/pengajuan_kerjasama.css') ?>" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content Wrapper -->
<div class="pengajuan-wrapper">
    <div class="container">
        
        <!-- Page Header -->
        <div class="pengajuan-page-header" data-aos="fade-down">
            <div class="pengajuan-header-content">
                <h1 class="pengajuan-page-title">Permohonan Kerja Sama</h1>
                <div class="pengajuan-breadcrumb">
                    <span>Kerja Sama</span>
                    <span class="separator">/</span>
                    <span class="current">Permohonan Kerja Sama</span>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="pengajuan-form-section" data-aos="fade-up" data-aos-delay="200">
            <div class="pengajuan-form-container">
                <form id="pengajuanForm" class="pengajuan-form" enctype="multipart/form-data">
                    
                    <!-- Jenis Permohonan Section -->
                    <div class="pengajuan-form-group">
                        <label class="pengajuan-form-label">Jenis Permohonan</label>
                        <div class="pengajuan-radio-group">
                            <div class="pengajuan-radio-item">
                                <input type="radio" id="jenis_baru" name="jenis_permohonan" value="baru" class="pengajuan-radio-input" checked>
                                <label for="jenis_baru" class="pengajuan-radio-label">
                                    <span class="pengajuan-radio-custom"></span>
                                    Baru
                                </label>
                            </div>
                            <div class="pengajuan-radio-item">
                                <input type="radio" id="jenis_perpanjangan" name="jenis_permohonan" value="perpanjangan" class="pengajuan-radio-input">
                                <label for="jenis_perpanjangan" class="pengajuan-radio-label">
                                    <span class="pengajuan-radio-custom"></span>
                                    Perpanjangan
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Two Column Layout -->
                    <div class="pengajuan-form-row">
                        
                        <!-- Left Column -->
                        <div class="pengajuan-form-column">
                            
                            <!-- Lembaga Field -->
                            <div class="pengajuan-form-group">
                                <label for="lembaga" class="pengajuan-form-label">Lembaga:</label>
                                <input type="text" 
                                       id="lembaga" 
                                       name="lembaga" 
                                       class="pengajuan-form-input" 
                                       placeholder="Masukkan nama lembaga"
                                       required>
                            </div>

                            <!-- Telp Field -->
                            <div class="pengajuan-form-group">
                                <label for="telp" class="pengajuan-form-label">
                                    Telp:<br>
                                    <small class="pengajuan-form-example">Contoh: 021-54321321</small>
                                </label>
                                <input type="tel" 
                                       id="telp" 
                                       name="telp" 
                                       class="pengajuan-form-input" 
                                       placeholder="021-54321321"
                                       pattern="[0-9\-\+\(\)\s]+"
                                       required>
                            </div>

                            <!-- Unit Terkait Field -->
                            <div class="pengajuan-form-group">
                                <label for="unit_terkait" class="pengajuan-form-label">Unit Terkait:</label>
                                <input type="text" 
                                       id="unit_terkait" 
                                       name="unit_terkait" 
                                       class="pengajuan-form-input" 
                                       placeholder="Masukkan unit terkait"
                                       required>
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="pengajuan-form-column">
                            
                            <!-- Alamat Field -->
                            <div class="pengajuan-form-group">
                                <label for="alamat" class="pengajuan-form-label">Alamat:</label>
                                <input type="text" 
                                       id="alamat" 
                                       name="alamat" 
                                       class="pengajuan-form-input" 
                                       placeholder="Masukkan alamat lengkap"
                                       required>
                            </div>

                            <!-- Email Field -->
                            <div class="pengajuan-form-group">
                                <label for="email" class="pengajuan-form-label">
                                    Email:<br>
                                    <small class="pengajuan-form-example">Contoh: example@domain.com</small>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="pengajuan-form-input" 
                                       placeholder="example@domain.com"
                                       required>
                            </div>

                            <!-- Upload Formulir Field -->
                            <div class="pengajuan-form-group">
                                <label for="formulir" class="pengajuan-form-label">Upload Formulir:</label>
                                <div class="pengajuan-file-upload">
                                    <input type="file" 
                                           id="formulir" 
                                           name="formulir" 
                                           class="pengajuan-file-input" 
                                           accept=".pdf,.doc,.docx"
                                           required>
                                    <label for="formulir" class="pengajuan-file-label">
                                        <i class="fas fa-upload"></i>
                                        <span class="pengajuan-file-text">Pilih file atau drag & drop</span>
                                        <small class="pengajuan-file-info">PDF, DOC, DOCX (Max: 5MB)</small>
                                    </label>
                                    <div class="pengajuan-file-preview" id="filePreview" style="display: none;">
                                        <i class="fas fa-file"></i>
                                        <span class="pengajuan-file-name"></span>
                                        <button type="button" class="pengajuan-file-remove" onclick="removeFile()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Kontak yang dapat dihubungi Field (Full Width) -->
                    <div class="pengajuan-form-group pengajuan-form-full">
                        <label for="kontak" class="pengajuan-form-label">Kontak yang dapat dihubungi:</label>
                        <textarea id="kontak" 
                                  name="kontak" 
                                  class="pengajuan-form-textarea" 
                                  rows="3" 
                                  placeholder="Masukkan informasi kontak yang dapat dihubungi"
                                  required></textarea>
                    </div>

                    <!-- Form Actions -->
                    <div class="pengajuan-form-actions">
                        <button type="button" class="pengajuan-btn pengajuan-btn-reset" id="resetBtn">
                            Reset
                        </button>
                        <button type="submit" class="pengajuan-btn pengajuan-btn-submit" id="submitBtn">
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="pengajuan-modal" id="successModal" style="display: none;">
            <div class="pengajuan-modal-content">
                <div class="pengajuan-modal-header">
                    <h3><i class="fas fa-check-circle"></i> Berhasil!</h3>
                </div>
                <div class="pengajuan-modal-body">
                    <p>Permohonan kerja sama Anda telah berhasil dikirim. Tim kami akan menghubungi Anda dalam 1-3 hari kerja.</p>
                </div>
                <div class="pengajuan-modal-footer">
                    <button type="button" class="pengajuan-btn pengajuan-btn-submit" onclick="closeModal()">
                        OK
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });
</script>
<script src="<?= base_url('js/public/pengajuan_kerjasama.js') ?>"></script>
<?= $this->endSection() ?>