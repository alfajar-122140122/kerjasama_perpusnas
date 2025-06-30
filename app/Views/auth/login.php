<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="login-card">
    <div class="text-center mb-4">
        <h2 class="login-title">Silahkan Login</h2>
        <div class="logo-container">
            <img src="<?= base_url('images/logo-perpusnas.png') ?>" alt="Logo Perpusnas" class="logo">
            <p class="logo-text">PERPUSTAKAAN NASIONAL</p>
        </div>
    </div>
    
    <!-- Form Login -->
    <form action="<?= base_url('auth/login') ?>" method="POST" id="loginForm">
        <?= csrf_field() ?>
        
        <!-- Alert untuk error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Username Field -->
        <div class="mb-3">
            <input type="text" 
                   class="form-control login-input" 
                   name="username" 
                   placeholder="Username" 
                   value="<?= old('username') ?>"
                   required>
            <?php if (isset($validation) && $validation->getError('username')): ?>
                <div class="text-danger small mt-1"><?= $validation->getError('username') ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Password Field -->
        <div class="mb-4">
            <input type="password" 
                   class="form-control login-input" 
                   name="password" 
                   placeholder="Password" 
                   required>
            <?php if (isset($validation) && $validation->getError('password')): ?>
                <div class="text-danger small mt-1"><?= $validation->getError('password') ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Login Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-login">Login</button>
        </div>
    </form>
    
    <!-- Forgot Password Link (opsional) -->
    <div class="text-center mt-3">
        <a href="#" class="forgot-password">Lupa Password?</a>
    </div>
</div>
<?= $this->endSection() ?>