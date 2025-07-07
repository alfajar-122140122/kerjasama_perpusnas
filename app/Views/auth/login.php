<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="login-card">
    <!-- Alert untuk error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Alert untuk success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Form Login -->
    <form action="<?= base_url('auth/login') ?>" method="POST" id="loginForm">
        <?= csrf_field() ?>
        
        <!-- Username Field -->
        <div class="mb-3">
            <label for="username" class="form-label">Username atau Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" 
                       id="username"
                       class="form-control <?= (isset($validation) && $validation->getError('username')) ? 'is-invalid' : '' ?>" 
                       name="username" 
                       placeholder="Masukkan username atau email" 
                       value="<?= old('username') ?>"
                       required
                       autocomplete="username">
            </div>
            <?php if (isset($validation) && $validation->getError('username')): ?>
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i><?= $validation->getError('username') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" 
                       id="password"
                       class="form-control <?= (isset($validation) && $validation->getError('password')) ? 'is-invalid' : '' ?>" 
                       name="password" 
                       placeholder="Masukkan password" 
                       required
                       autocomplete="current-password">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            <?php if (isset($validation) && $validation->getError('password')): ?>
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i><?= $validation->getError('password') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>
            <a href="<?= base_url('auth/forgot-password') ?>" class="small">
                Lupa Password?
            </a>
        </div>
        
        <!-- Login Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-login btn-lg">
                <span class="btn-content">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </span>
                <div class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </button>
        </div>
        
        <!-- Demo Credentials -->
        <div class="alert alert-info" role="alert">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1"></i>
                <div>
                    <small class="fw-semibold">Demo Login:</small><br>
                    <small>Username: <span class="badge bg-primary">admin</span></small><br>
                    <small>Password: <span class="badge bg-primary">password</span></small>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Footer Links -->
    <div class="text-center">
        <a href="<?= base_url('/') ?>" class="small text-muted">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Form submission with loading
document.getElementById('loginForm').addEventListener('submit', function() {
    const button = this.querySelector('.btn-login');
    const content = button.querySelector('.btn-content');
    const spinner = button.querySelector('.spinner-border');
    
    button.classList.add('loading');
    button.disabled = true;
    content.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    spinner.classList.remove('d-none');
});
</script>
<?= $this->endSection() ?>