<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Pengaturan<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Pengaturan Akun<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="page-title">Pengaturan Akun</h2>
        <p class="text-muted mb-4">Kelola profil dan pengaturan akun Anda</p>
    </div>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<div class="row">
    <!-- Profile Settings -->
    <div class="col-lg-8">
        <div class="card settings-card">
            <div class="card-header py-3 profile-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-edit me-2"></i>Informasi Profil
                </h6>
            </div>
            <div class="card-body">
                <form id="profileForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= esc($user['name']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" value="<?= esc($user['username']) ?>" readonly>
                                <div class="form-text">Username tidak dapat diubah</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= esc($user['phone']) ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role" value="<?= esc($user['role']) ?>" readonly>
                                <div class="form-text">Role ditentukan oleh administrator</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="created_at" class="form-label">Bergabung Sejak</label>
                                <input type="text" class="form-control" value="<?= date('d F Y', strtotime($user['created_at'])) ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Account Info Sidebar -->
    <div class="col-lg-4">
        <div class="card settings-card">
            <div class="card-header py-3 account-info-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>Informasi Akun
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="user-avatar-large mb-3">
                    <div class="avatar-circle-large">
                        <?= strtoupper(substr($user['name'], 0, 2)) ?>
                    </div>
                </div>
                <h5 class="mb-1"><?= esc($user['name']) ?></h5>
                <p class="text-muted mb-2">@<?= esc($user['username']) ?></p>
                <span class="badge bg-<?= $user['role'] === 'Admin' ? 'primary' : 'secondary' ?> mb-3">
                    <?= esc($user['role']) ?>
                </span>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i>
                        </div>
                        <small class="text-muted">Bergabung</small>
                        <div class="fw-bold"><?= date('M Y', strtotime($user['created_at'])) ?></div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-clock text-success"></i>
                        </div>
                        <small class="text-muted">Login Terakhir</small>
                        <div class="fw-bold"><?= date('H:i', strtotime($user['last_login'])) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Settings -->
<div class="row">
    <div class="col-12">
        <div class="card settings-card">
            <div class="card-header py-3 security-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
                </h6>
            </div>
            <div class="card-body">
                <h6>Ubah Password</h6>
                <p class="text-muted mb-4">Pastikan akun Anda menggunakan password yang kuat untuk menjaga keamanan.</p>
                
                <form id="passwordForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password', 'currentToggle')">
                                        <i class="fas fa-eye" id="currentToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', 'newToggle')">
                                        <i class="fas fa-eye" id="newToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password', 'confirmToggle')">
                                        <i class="fas fa-eye" id="confirmToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mb-3">
                        <label class="form-label">Kekuatan Password:</label>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted">Masukkan password baru untuk melihat kekuatan</small>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/settings-management.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Set base URL for AJAX calls
    const baseUrl = '<?= base_url() ?>';
</script>
<script src="<?= base_url('js/settings-management.js') ?>"></script>
<?= $this->endSection() ?>