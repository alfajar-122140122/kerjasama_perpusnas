<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="auth-container">
    <!-- Left Side - Brand Section -->
    <div class="auth-brand">
        <div class="auth-brand-content">
            <a href="<?= base_url('/') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            
            <h1 class="brand-title">Portal<br>Kerjasama<br>Perpusnas</h1>
        </div>
    </div>
    
    <!-- Right Side - Login Form -->
    <div class="auth-form-section">
        <!-- Header -->
        <div class="auth-header">
            <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Perpusnas Logo" class="auth-logo">
            <p class="auth-title">Perpustakaan Nasional<br>Republik Indonesia</p>
            <h2 class="login-title">Login</h2>
        </div>
        
        <!-- Alert untuk error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Alert untuk success -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Form Login -->
        <form action="<?= base_url('auth/login') ?>" method="POST" id="loginForm" class="login-form">
            <?= csrf_field() ?>
            
            <!-- Username Field -->
            <div class="form-group">
                <label for="username" class="form-label">Username atau Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" 
                           id="username"
                           class="form-control <?= (isset($validation) && $validation->getError('username')) ? 'is-invalid' : '' ?>" 
                           name="username" 
                           placeholder="username" 
                           value="<?= old('username') ?>"
                           required
                           autocomplete="username">
                </div>
                <?php if (isset($validation) && $validation->getError('username')): ?>
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i><?= $validation->getError('username') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           id="password"
                           class="form-control <?= (isset($validation) && $validation->getError('password')) ? 'is-invalid' : '' ?>" 
                           name="password" 
                           placeholder="password" 
                           required
                           autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                <?php if (isset($validation) && $validation->getError('password')): ?>
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i><?= $validation->getError('password') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Login Button -->
            <button type="submit" class="btn btn-login">
                <span class="btn-content">Login</span>
            </button>
            
            <!-- Forgot Password Link -->
            <a href="<?= base_url('auth/forgot-password') ?>" class="forgot-password-link">
                Lupa Password?
            </a>
        </form>
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
    
    button.classList.add('loading');
    button.disabled = true;
    content.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
});
</script>
<?= $this->endSection() ?>