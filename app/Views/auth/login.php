<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="login-card">
    <div class="text-center mb-4">
        <h2 class="login-title">Silahkan Login</h2>
        <div class="logo-container">
            <img src="<?= base_url('images/logo-perpusnas.png') ?>" alt="Logo Perpusnas" class="logo">
            <p class="logo-text">PERPUSTAKAAN NASIONAL RI</p>
        </div>
    </div>
    
    <!-- Alert untuk error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Alert untuk success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Form Login -->
    <form action="<?= base_url('auth/login') ?>" method="POST" id="loginForm">
        <?= csrf_field() ?>
        
        <!-- Username Field -->
        <div class="mb-3">
            <input type="text" 
                   class="form-control login-input <?= (isset($validation) && $validation->getError('username')) ? 'is-invalid' : '' ?>" 
                   name="username" 
                   placeholder="Username atau Email" 
                   value="<?= old('username') ?>"
                   required
                   autocomplete="username">
            <?php if (isset($validation) && $validation->getError('username')): ?>
                <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Password Field -->
        <div class="mb-3">
            <div class="position-relative">
                <input type="password" 
                       class="form-control login-input <?= (isset($validation) && $validation->getError('password')) ? 'is-invalid' : '' ?>" 
                       name="password" 
                       placeholder="Password" 
                       id="password"
                       required
                       autocomplete="current-password">
                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-2" 
                        onclick="togglePassword()" style="border: none; background: none; color: #666;">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            <?php if (isset($validation) && $validation->getError('password')): ?>
                <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">
                Ingat saya
            </label>
        </div>
        
        <!-- Login Button -->
        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </div>
        
        <!-- Demo Credentials -->
        <div class="alert alert-info" role="alert">
            <small>
                <strong>Demo Login:</strong><br>
                Username: <code>admin</code><br>
                Password: <code>password</code>
            </small>
        </div>
    </form>
    
    <!-- Links -->
    <div class="text-center">
        <a href="<?= base_url('auth/forgot-password') ?>" class="forgot-password">
            <i class="fas fa-question-circle me-1"></i>Lupa Password?
        </a>
    </div>
    
    <hr class="my-4">
    
    <div class="text-center">
        <small class="text-muted">
            <a href="<?= base_url('/') ?>" class="forgot-password">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
            </a>
        </small>
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
</script>
<?= $this->endSection() ?>