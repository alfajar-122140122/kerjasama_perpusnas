let currentUserId = null;

// Document ready
document.addEventListener('DOMContentLoaded', function() {
    initializeUserManagement();
});

// Initialize user management functionality
function initializeUserManagement() {
    // Event delegation for edit buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit')) {
            const button = e.target.closest('.btn-edit');
            const userId = button.getAttribute('data-user-id');
            const username = button.getAttribute('data-username');
            const hakAkses = button.getAttribute('data-hak-akses');
            const email = button.getAttribute('data-email');
            
            editUser(userId, username, hakAkses, email);
        }
        
        if (e.target.closest('.btn-delete')) {
            const button = e.target.closest('.btn-delete');
            const userId = button.getAttribute('data-user-id');
            const username = button.getAttribute('data-username');
            
            deleteUser(userId, username);
        }
    });
    
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // Update select all when individual checkboxes change
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === userCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
        });
    });
}

// Edit user function with data from attributes
function editUser(userId, username, hakAkses, email) {
    currentUserId = userId;
    
    // Populate edit form with data from attributes
    document.getElementById('edit_user_id').value = userId;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_hak_akses').value = hakAkses;
    document.getElementById('edit_email').value = email || ''; // Handle email
    
    // Set form action
    document.getElementById('editUserForm').action = window.BASE_URL + '/admin/users/edit/' + userId;
    
    // Show modal
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();
}

// Delete user function
function deleteUser(userId, username) {
    if (confirm(`Apakah Anda yakin ingin menghapus user "${username}"?`)) {
        // Show loading state
        showLoadingState(true);
        
        // Redirect to delete URL
        window.location.href = window.BASE_URL + '/admin/users/delete/' + userId;
    }
}

// Toggle Password Visibility
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Password Strength Checker
function checkPasswordStrength(input, mode) {
    const value = input.value;
    let score = 0;
    let feedback = '';
    let bar = null;
    let text = null;

    if (mode === 'add') {
        bar = document.getElementById('passwordStrengthAdd');
        text = document.getElementById('passwordStrengthTextAdd');
    } else {
        bar = document.getElementById('passwordStrengthEdit');
        text = document.getElementById('passwordStrengthTextEdit');
    }

    // Check for each requirement
    if (value.length >= 8) score++;
    if (/[a-z]/.test(value)) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/\d/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;

    // Set feedback and bar color
    switch (score) {
        case 0:
        case 1:
            bar.style.width = '20%';
            bar.className = 'progress-bar bg-danger';
            feedback = 'Sangat Lemah';
            break;
        case 2:
            bar.style.width = '40%';
            bar.className = 'progress-bar bg-warning';
            feedback = 'Lemah';
            break;
        case 3:
            bar.style.width = '60%';
            bar.className = 'progress-bar bg-info';
            feedback = 'Sedang';
            break;
        case 4:
            bar.style.width = '80%';
            bar.className = 'progress-bar bg-primary';
            feedback = 'Kuat';
            break;
        case 5:
            bar.style.width = '100%';
            bar.className = 'progress-bar bg-success';
            feedback = 'Sangat Kuat';
            break;
    }

    if (value.length === 0) {
        bar.style.width = '0%';
        bar.className = 'progress-bar';
        feedback = 'Masukkan password untuk melihat kekuatan';
    }

    text.textContent = feedback;
}

// Show Alert Function
function showAlert(type, message) {
    const alertContainer = document.querySelector('.content') || document.body;
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.insertBefore(alert, alertContainer.firstChild);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Show loading state
function showLoadingState(show) {
    const buttons = document.querySelectorAll('.btn-edit, .btn-delete');
    
    buttons.forEach(button => {
        if (show) {
            button.disabled = true;
            button.style.opacity = '0.6';
        } else {
            button.disabled = false;
            button.style.opacity = '1';
        }
    });
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// Clear form validation
function clearFormValidation(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('.is-invalid');
    
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
}

// Form submit handlers
document.addEventListener('submit', function(e) {
    if (e.target.id === 'editUserForm') {
        if (!validateForm('editUserForm')) {
            e.preventDefault();
            showAlert('danger', 'Mohon lengkapi semua field yang diperlukan');
            return false;
        }
        
        // Show loading
        const submitBtn = e.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    }
});

// Modal event handlers
document.getElementById('addUserModal').addEventListener('hidden.bs.modal', function() {
    clearFormValidation('addUserModal');
});

document.getElementById('editUserModal').addEventListener('hidden.bs.modal', function() {
    clearFormValidation('editUserModal');
    
    // Reset submit button
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = false;
    submitBtn.innerHTML = 'Update User';
});

// Input validation on blur
document.addEventListener('blur', function(e) {
    if (e.target.hasAttribute('required')) {
        if (!e.target.value.trim()) {
            e.target.classList.add('is-invalid');
        } else {
            e.target.classList.remove('is-invalid');
        }
    }
}, true);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+N for new user
    if (e.ctrlKey && e.key === 'n') {
        e.preventDefault();
        const addButton = document.querySelector('.btn-add-user');
        if (addButton) {
            addButton.click();
        }
    }
    
    // ESC to close modals
    if (e.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal.show');
        openModals.forEach(modal => {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
        });
    }
});

// Search functionality (if needed)
function searchUsers(query) {
    const rows = document.querySelectorAll('.user-row');
    
    rows.forEach(row => {
        const username = row.querySelector('.user-name').textContent.toLowerCase();
        const hakAkses = row.querySelector('.user-role-badge').textContent.toLowerCase();
        
        if (username.includes(query.toLowerCase()) || hakAkses.includes(query.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Export selected users (future feature)
function exportSelectedUsers() {
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        showAlert('warning', 'Pilih minimal satu user untuk diekspor');
        return;
    }
    
    // Implementation for export functionality
    console.log('Exporting users:', selectedIds);
}

// Bulk delete (future feature)
function bulkDeleteUsers() {
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        showAlert('warning', 'Pilih minimal satu user untuk dihapus');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} user yang dipilih?`)) {
        // Implementation for bulk delete
        console.log('Bulk deleting users:', selectedIds);
    }
}