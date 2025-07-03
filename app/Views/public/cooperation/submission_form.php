<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Permohonan Kerjasama</h2>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <p class="mb-4">Silakan isi formulir di bawah ini untuk mengajukan permohonan kerjasama dengan Perpustakaan Nasional.</p>
                    
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-success">
                            <?= session('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach(session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/cooperation/submit-proposal" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_pengaju" class="form-label">Nama Pengaju <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_pengaju')) ? 'is-invalid' : '' ?>" id="nama_pengaju" name="nama_pengaju" value="<?= old('nama_pengaju') ?>">
                                <?php if(isset($validation) && $validation->hasError('nama_pengaju')): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('nama_pengaju') ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>">
                                <?php if(isset($validation) && $validation->hasError('email')): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('telepon')) ? 'is-invalid' : '' ?>" id="telepon" name="telepon" value="<?= old('telepon') ?>">
                            <?php if(isset($validation) && $validation->hasError('telepon')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('telepon') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_instansi" class="form-label">Nama Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_instansi')) ? 'is-invalid' : '' ?>" id="nama_instansi" name="nama_instansi" value="<?= old('nama_instansi') ?>">
                            <?php if(isset($validation) && $validation->hasError('nama_instansi')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('nama_instansi') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat_instansi" class="form-label">Alamat Instansi <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= (isset($validation) && $validation->hasError('alamat_instansi')) ? 'is-invalid' : '' ?>" id="alamat_instansi" name="alamat_instansi" rows="3"><?= old('alamat_instansi') ?></textarea>
                            <?php if(isset($validation) && $validation->hasError('alamat_instansi')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('alamat_instansi') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="jenis_kerjasama" class="form-label">Jenis Kerjasama <span class="text-danger">*</span></label>
                            <select class="form-select <?= (isset($validation) && $validation->hasError('jenis_kerjasama')) ? 'is-invalid' : '' ?>" id="jenis_kerjasama" name="jenis_kerjasama">
                                <option value="" <?= old('jenis_kerjasama') == '' ? 'selected' : '' ?>>-- Pilih Jenis Kerjasama --</option>
                                <option value="Pertukaran Koleksi" <?= old('jenis_kerjasama') == 'Pertukaran Koleksi' ? 'selected' : '' ?>>Pertukaran Koleksi</option>
                                <option value="Digitalisasi" <?= old('jenis_kerjasama') == 'Digitalisasi' ? 'selected' : '' ?>>Digitalisasi</option>
                                <option value="Pengembangan SDM" <?= old('jenis_kerjasama') == 'Pengembangan SDM' ? 'selected' : '' ?>>Pengembangan SDM</option>
                                <option value="Penelitian" <?= old('jenis_kerjasama') == 'Penelitian' ? 'selected' : '' ?>>Penelitian</option>
                                <option value="Lainnya" <?= old('jenis_kerjasama') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <?php if(isset($validation) && $validation->hasError('jenis_kerjasama')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('jenis_kerjasama') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi_kerjasama" class="form-label">Deskripsi Kerjasama <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= (isset($validation) && $validation->hasError('deskripsi_kerjasama')) ? 'is-invalid' : '' ?>" id="deskripsi_kerjasama" name="deskripsi_kerjasama" rows="5"><?= old('deskripsi_kerjasama') ?></textarea>
                            <?php if(isset($validation) && $validation->hasError('deskripsi_kerjasama')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('deskripsi_kerjasama') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file_proposal" class="form-label">Upload Proposal (PDF, max 10MB) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control <?= (isset($validation) && $validation->hasError('file_proposal')) ? 'is-invalid' : '' ?>" id="file_proposal" name="file_proposal">
                            <?php if(isset($validation) && $validation->hasError('file_proposal')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('file_proposal') ?></div>
                            <?php endif; ?>
                            <div class="form-text">Format file: PDF, ukuran maksimal 10MB</div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agreement" name="agreement" required>
                            <label class="form-check-label" for="agreement">Saya menyatakan bahwa data yang saya masukkan adalah benar dan dapat dipertanggungjawabkan.</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
