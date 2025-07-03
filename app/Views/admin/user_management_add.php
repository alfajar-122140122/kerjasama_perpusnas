<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Tambah User Baru</h2>
            <p class="text-muted mb-4">Tambah akun pengguna sistem kerjasama Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
                </div>
                <div class="card-body">
                    <form id="addUserForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                    <small class="text-muted">Username harus unik dan tidak mengandung spasi</small>
                                    <div class="invalid-feedback" id="username-feedback"></div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback" id="email-feedback"></div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin">Administrator</option>
                                        <option value="staff">Staff</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" type="button" id="generatePasswordBtn">
                                            <i class="fa fa-key"></i> Generate
                                        </button>
                                    </div>
                                    <div class="mt-2 password-strength"></div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="confirm_password">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Status Akun</label>
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                        <label class="custom-control-label" for="status">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                                <a href="<?= site_url('admin/user-management') ?>" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('.toggle-password').click(function() {
        const passwordField = $(this).parent().find('input');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        
        const icon = $(this).find('i');
        icon.toggleClass('fa-eye-slash fa-eye');
    });
    
    // Generate random password
    $('#generatePasswordBtn').click(function() {
        $.ajax({
            url: '<?= site_url('admin/users/generate-password') ?>',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#password').val(response.password);
                    $('#confirm_password').val(response.password);
                    checkPasswordStrength(response.password);
                } else {
                    showAlert('error', 'Gagal generate password');
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan server');
            }
        });
    });
    
    // Check password strength
    $('#password').on('input', function() {
        const password = $(this).val();
        checkPasswordStrength(password);
    });
    
    // Check username availability
    $('#username').on('blur', function() {
        const username = $(this).val().trim();
        if (username !== '') {
            checkUsername(username);
        }
    });
    
    // Check email availability
    $('#email').on('blur', function() {
        const email = $(this).val().trim();
        if (email !== '' && isValidEmail(email)) {
            checkEmail(email);
        }
    });
    
    // Form submission
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return false;
        }
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: '<?= site_url('admin/users/create') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    setTimeout(function() {
                        window.location.href = '<?= site_url('admin/user-management') ?>';
                    }, 1500);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan server');
            }
        });
    });
    
    // Helper functions
    function checkPasswordStrength(password) {
        $.ajax({
            url: '<?= site_url('auth/check-password-strength') ?>',
            type: 'POST',
            data: { password: password },
            dataType: 'json',
            success: function(response) {
                const strengthDiv = $('.password-strength');
                let strengthClass = '';
                
                switch(response.strength) {
                    case 'weak':
                        strengthClass = 'text-danger';
                        break;
                    case 'medium':
                        strengthClass = 'text-warning';
                        break;
                    case 'strong':
                        strengthClass = 'text-success';
                        break;
                    default:
                        strengthClass = 'text-danger';
                }
                
                strengthDiv.html(`
                    <small class="${strengthClass}">
                        ${response.message}
                    </small>
                `);
            }
        });
    }
    
    function checkUsername(username) {
        $.ajax({
            url: '<?= site_url('admin/users/check-username') ?>',
            type: 'POST',
            data: { username: username },
            dataType: 'json',
            success: function(response) {
                if (!response.available) {
                    $('#username').addClass('is-invalid');
                    $('#username-feedback').text('Username sudah digunakan');
                } else {
                    $('#username').removeClass('is-invalid');
                    $('#username-feedback').text('');
                }
            }
        });
    }
    
    function checkEmail(email) {
        $.ajax({
            url: '<?= site_url('admin/users/check-email') ?>',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                if (!response.available) {
                    $('#email').addClass('is-invalid');
                    $('#email-feedback').text('Email sudah digunakan');
                } else {
                    $('#email').removeClass('is-invalid');
                    $('#email-feedback').text('');
                }
            }
        });
    }
    
    function validateForm() {
        let isValid = true;
        
        // Validate password match
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (password !== confirmPassword) {
            showAlert('error', 'Password dan konfirmasi password tidak cocok');
            isValid = false;
        }
        
        return isValid;
    }
    
    function isValidEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }
    
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertIcon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        
        $('#alertContainer').html(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fa ${alertIcon} mr-1"></i> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);
        
        // Auto-close alert after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
