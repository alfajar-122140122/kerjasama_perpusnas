/**
 * Settings Management JavaScript
 * Handles profile updates, password changes, and form validation
 */

// Global variables
let isProcessing = false;

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    initializeSettings();
});

/**
 * Initialize settings page functionality
 */
function initializeSettings() {
    // Initialize form handlers
    initializeProfileForm();
    initializePasswordForm();
    initializePasswordStrengthChecker();
    initializeFormValidation();
    
    console.log('Settings management initialized');
}

/**
 * Initialize profile form handler
 */
function initializeProfileForm() {
    const profileForm = document.getElementById('profileForm');
    if (!profileForm) return;
    
    profileForm.addEventListener('submit', handleProfileUpdate);
}

/**
 * Handle profile update form submission
 */
function handleProfileUpdate(e) {
    e.preventDefault();
    
    if (isProcessing) return;
    isProcessing = true;
    
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading state
    setButtonLoading(submitBtn, 'Menyimpan...');
    
    // Clear previous errors
    clearFormErrors(form);
    
    // Make API call
    fetch(baseUrl + 'admin/pengaturan/update-profile', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || 'Profil berhasil diperbarui');
            updateUserDisplay();
        } else {
            showAlert('danger', data.message || 'Gagal memperbarui profil');
            if (data.errors) {
                showFormErrors(form, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Profile update error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui profil');
    })
    .finally(() => {
        restoreButton(submitBtn, originalContent);
        isProcessing = false;
    });
}

/**
 * Initialize password form handler
 */
function initializePasswordForm() {
    const passwordForm = document.getElementById('passwordForm');
    if (!passwordForm) return;
    
    passwordForm.addEventListener('submit', handlePasswordChange);
}

/**
 * Handle password change form submission
 */
function handlePasswordChange(e) {
    e.preventDefault();
    
    if (isProcessing) return;
    
    const form = e.target;
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Client-side validation
    if (!validatePasswordForm(newPassword, confirmPassword)) {
        return;
    }
    
    isProcessing = true;
    
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading state
    setButtonLoading(submitBtn, 'Mengubah...');
    
    // Clear previous errors
    clearFormErrors(form);
    
    // Make API call
    fetch(baseUrl + 'admin/pengaturan/change-password', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || 'Password berhasil diubah');
            form.reset();
            updatePasswordStrength('');
        } else {
            showAlert('danger', data.message || 'Gagal mengubah password');
            if (data.errors) {
                showFormErrors(form, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Password change error:', error);
        showAlert('danger', 'Terjadi kesalahan saat mengubah password');
    })
    .finally(() => {
        restoreButton(submitBtn, originalContent);
        isProcessing = false;
    });
}

/**
 * Validate password form
 */
function validatePasswordForm(newPassword, confirmPassword) {
    let isValid = true;
    
    // Check minimum length
    if (newPassword.length < 6) {
        showAlert('danger', 'Password baru minimal 6 karakter');
        document.getElementById('new_password').classList.add('is-invalid');
        isValid = false;
    }
    
    // Check password match
    if (newPassword !== confirmPassword) {
        showAlert('danger', 'Konfirmasi password tidak sama');
        document.getElementById('confirm_password').classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

/**
 * Initialize password strength checker
 */
function initializePasswordStrengthChecker() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            updatePasswordStrength(this.value);
            
            // Check password match
            if (confirmPasswordInput.value && confirmPasswordInput.value !== this.value) {
                confirmPasswordInput.classList.add('is-invalid');
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
            }
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const newPassword = newPasswordInput ? newPasswordInput.value : '';
            if (this.value && this.value !== newPassword) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
}

/**
 * Update password strength indicator
 */
function updatePasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');
    
    if (!strengthBar || !strengthText) return;
    
    let strength = 0;
    let strengthLabel = '';
    let strengthClass = '';
    
    // Calculate strength
    if (password.length >= 6) strength += 1;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
    if (password.match(/[0-9]/)) strength += 1;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
    
    // Determine strength level
    switch (strength) {
        case 0:
        case 1:
            strengthLabel = 'Lemah';
            strengthClass = 'bg-danger';
            break;
        case 2:
            strengthLabel = 'Sedang';
            strengthClass = 'bg-warning';
            break;
        case 3:
        case 4:
            strengthLabel = 'Kuat';
            strengthClass = 'bg-success';
            break;
    }
    
    // Update UI
    const percentage = (strength / 4) * 100;
    strengthBar.style.width = percentage + '%';
    strengthBar.className = `progress-bar ${strengthClass}`;
    strengthText.textContent = password ? strengthLabel : 'Masukkan password baru untuk melihat kekuatan';
}

/**
 * Toggle password visibility
 */
function togglePasswordVisibility(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);
    
    if (!input || !toggle) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    // Clear validation errors on input
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
            }
        });
    });
}

/**
 * Update user display after profile update
 */
function updateUserDisplay() {
    const nameInput = document.getElementById('name');
    if (!nameInput) return;
    
    const name = nameInput.value;
    const initials = name.substring(0, 2).toUpperCase();
    
    // Update avatar
    const avatarElement = document.querySelector('.avatar-circle-large');
    if (avatarElement) {
        avatarElement.textContent = initials;
    }
    
    // Update name display
    const nameElement = document.querySelector('.card-body h5');
    if (nameElement) {
        nameElement.textContent = name;
    }
}

/**
 * Show alert message
 */
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {
                alert.remove();
            }
        }
    }, 5000);
}

/**
 * Show form validation errors
 */
function showFormErrors(form, errors) {
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = errors[field];
            }
        }
    });
}

/**
 * Clear form validation errors
 */
function clearFormErrors(form) {
    const inputs = form.querySelectorAll('.is-invalid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    const feedbacks = form.querySelectorAll('.invalid-feedback');
    feedbacks.forEach(feedback => {
        feedback.textContent = '';
    });
}

/**
 * Set button to loading state
 */
function setButtonLoading(button, loadingText) {
    button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>${loadingText}`;
    button.disabled = true;
}

/**
 * Restore button to original state
 */
function restoreButton(button, originalContent) {
    button.innerHTML = originalContent;
    button.disabled = false;
}

/**
 * Utility function to get base URL
 */
function getBaseUrl() {
    return window.baseUrl || location.origin + '/';
}

// Set base URL for API calls
const baseUrl = getBaseUrl();

// Export functions for global access
window.togglePasswordVisibility = togglePasswordVisibility;
window.updatePasswordStrength = updatePasswordStrength;
window.showAlert = showAlert;
