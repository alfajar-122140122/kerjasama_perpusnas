<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Edit User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Edit User</h2>
            <p class="text-muted mb-4">Edit data pengguna sistem kerjasama Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit User</h6>
                </div>
                <div class="card-body">
                    <form id="editUserForm">
                        <input type="hidden" id="user_id" name="user_id" value="<?= $user['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required readonly>
                                    <small class="text-muted">Username tidak dapat diubah</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                                    <div class="invalid-feedback" id="email-feedback"></div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $user['jabatan'] ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Administrator</option>
                                        <option value="staff" <?= ($user['role'] == 'staff') ? 'selected' : '' ?>>Staff</option>
                                        <option value="supervisor" <?= ($user['role'] == 'supervisor') ? 'selected' : '' ?>>Supervisor</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="new_password">Password Baru <small>(biarkan kosong jika tidak ingin mengubah)</small></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" name="new_password">
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
                                    <label for="confirm_password">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Status Akun</label>
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" <?= ($user['is_active'] == 1) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="status">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update
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
                    $('#new_password').val(response.password);
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
    $('#new_password').on('input', function() {
        const password = $(this).val();
        if (password !== '') {
            checkPasswordStrength(password);
        } else {
            $('.password-strength').html('');
        }
    });
    
    // Check email availability
    $('#email').on('blur', function() {
        const email = $(this).val().trim();
        const currentEmail = '<?= $user['email'] ?>';
        
        if (email !== '' && email !== currentEmail && isValidEmail(email)) {
            checkEmail(email);
        }
    });
    
    // Form submission
    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return false;
        }
        
        const userId = $('#user_id').val();
        const formData = $(this).serialize();
        
        $.ajax({
            url: '<?= site_url('admin/users/update/') ?>' + userId,
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
        
        // Validate password match if new password is provided
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (newPassword !== '' && newPassword !== confirmPassword) {
            showAlert('error', 'Password baru dan konfirmasi password tidak cocok');
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
