/**
 * User Management JavaScript
 * Handles all user management functionality including CRUD operations, modals, and form validation
 */

class UserManagement {
    constructor() {
        this.currentViewUserId = null;
        this.currentUserId = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.initModals();
    }

    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('searchUser');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => this.handleSearch(e.target.value));
        }

        // Filter events
        const roleFilter = document.getElementById('filterRole');
        const statusFilter = document.getElementById('filterStatus');
        
        if (roleFilter) {
            roleFilter.addEventListener('change', (e) => this.handleRoleFilter(e.target.value));
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', (e) => this.handleStatusFilter(e.target.value));
        }

        // Form submissions
        this.bindFormEvents();
        
        // Password strength checker
        this.bindPasswordEvents();
    }

    bindFormEvents() {
        // Add user form
        const addForm = document.getElementById('addUserForm');
        if (addForm) {
            addForm.addEventListener('submit', (e) => this.handleAddUser(e));
        }

        // Edit user form
        const editForm = document.getElementById('editUserForm');
        if (editForm) {
            editForm.addEventListener('submit', (e) => this.handleEditUser(e));
        }

        // Change password form
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', (e) => this.handleChangePassword(e));
        }
    }

    bindPasswordEvents() {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        if (newPasswordInput) {
            newPasswordInput.addEventListener('input', (e) => {
                this.updatePasswordStrength(e.target.value);
                this.validatePasswordMatch();
            });
        }

        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', () => this.validatePasswordMatch());
        }
    }

    initModals() {
        // Initialize Bootstrap modals if needed
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', () => {
                this.resetModalForms(modal);
            });
        });
    }

    // Search Functions
    handleSearch(filter) {
        const rows = document.querySelectorAll('.user-row');
        const searchTerm = filter.toLowerCase();
        
        rows.forEach(row => {
            const name = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
            const username = row.querySelector('.user-username')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.user-email')?.textContent.toLowerCase() || '';
            
            const isMatch = name.includes(searchTerm) || 
                           username.includes(searchTerm) || 
                           email.includes(searchTerm);
            
            row.style.display = isMatch ? '' : 'none';
        });
    }

    handleRoleFilter(filter) {
        const rows = document.querySelectorAll('.user-row');
        
        rows.forEach(row => {
            if (!filter) {
                row.style.display = '';
                return;
            }
            
            const role = row.querySelector('.user-role')?.textContent.trim() || '';
            row.style.display = role === filter ? '' : 'none';
        });
    }

    handleStatusFilter(filter) {
        const rows = document.querySelectorAll('.user-row');
        
        rows.forEach(row => {
            if (!filter) {
                row.style.display = '';
                return;
            }
            
            const status = row.querySelector('.user-status')?.textContent.trim().toLowerCase() || '';
            row.style.display = status === filter ? '' : 'none';
        });
    }

    // User CRUD Operations
    viewUser(userId) {
        const userRow = document.querySelector(`[data-user-id="${userId}"]`);
        if (!userRow) return;
        
        this.currentViewUserId = userId;
        
        // Extract user data
        const userData = this.extractUserData(userRow);
        
        // Populate view modal
        this.populateViewModal(userData);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
        modal.show();
    }

    editUser(userId) {
        const userRow = document.querySelector(`[data-user-id="${userId}"]`);
        if (!userRow) return;
        
        // Extract user data
        const userData = this.extractUserData(userRow);
        
        // Populate edit form
        this.populateEditForm(userData);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
        modal.show();
    }

    deleteUser(userId) {
        const userRow = document.querySelector(`[data-user-id="${userId}"]`);
        if (!userRow) return;
        
        const userName = userRow.querySelector('.user-name')?.textContent || '';
        
        if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
            this.performDeleteUser(userId, userRow);
        }
    }

    // Modal Population Functions
    extractUserData(userRow) {
        return {
            id: userRow.dataset.userId,
            name: userRow.querySelector('.user-name')?.textContent || '',
            username: userRow.querySelector('.user-username')?.textContent.replace('@', '') || '',
            email: userRow.querySelector('.user-email')?.textContent || '',
            role: userRow.querySelector('.user-role')?.textContent.trim() || '',
            status: userRow.querySelector('.user-status')?.textContent.trim().toLowerCase() || ''
        };
    }

    populateViewModal(userData) {
        const elements = {
            avatar: document.getElementById('viewUserAvatar'),
            name: document.getElementById('viewUserName'),
            username: document.getElementById('viewUserUsername'),
            email: document.getElementById('viewUserEmail'),
            phone: document.getElementById('viewUserPhone'),
            role: document.getElementById('viewUserRole'),
            status: document.getElementById('viewUserStatus'),
            joined: document.getElementById('viewUserJoined'),
            lastLogin: document.getElementById('viewUserLastLogin')
        };

        if (elements.avatar) elements.avatar.textContent = userData.name.substring(0, 2).toUpperCase();
        if (elements.name) elements.name.textContent = userData.name;
        if (elements.username) elements.username.textContent = '@' + userData.username;
        if (elements.email) elements.email.textContent = userData.email;
        if (elements.phone) elements.phone.textContent = 'Tidak ada';
        if (elements.role) {
            elements.role.textContent = userData.role;
            elements.role.className = `badge bg-${userData.role === 'Admin' ? 'primary' : 'secondary'}`;
        }
        if (elements.status) {
            const statusBadge = userData.status === 'active' ? 'success' : 'danger';
            const statusText = userData.status === 'active' ? 'Aktif' : 'Tidak Aktif';
            elements.status.innerHTML = `<span class="badge bg-${statusBadge}">${statusText}</span>`;
        }
        if (elements.joined) elements.joined.textContent = '01 Januari 2024';
        if (elements.lastLogin) elements.lastLogin.textContent = 'Belum pernah login';
    }

    populateEditForm(userData) {
        const elements = {
            id: document.getElementById('edit_user_id'),
            name: document.getElementById('edit_name'),
            username: document.getElementById('edit_username'),
            email: document.getElementById('edit_email'),
            phone: document.getElementById('edit_phone'),
            role: document.getElementById('edit_role'),
            status: document.getElementById('edit_status')
        };

        if (elements.id) elements.id.value = userData.id;
        if (elements.name) elements.name.value = userData.name;
        if (elements.username) elements.username.value = userData.username;
        if (elements.email) elements.email.value = userData.email;
        if (elements.phone) elements.phone.value = '';
        if (elements.role) elements.role.value = userData.role;
        if (elements.status) elements.status.value = userData.status === 'aktif' ? 'active' : 'inactive';
    }

    // Form Handlers
    handleAddUser(e) {
        e.preventDefault();
        
        if (!this.validateForm(e.target)) {
            return;
        }

        const formData = new FormData(e.target);
        this.showLoadingState(e.target.querySelector('button[type="submit"]'));
        
        // Simulate API call
        setTimeout(() => {
            this.showAlert('success', 'User berhasil ditambahkan');
            this.hideModal('addUserModal');
            this.hideLoadingState(e.target.querySelector('button[type="submit"]'), 'Simpan User');
            this.addUserToTable(formData);
        }, 1000);
    }

    handleEditUser(e) {
        e.preventDefault();
        
        if (!this.validateForm(e.target)) {
            return;
        }

        const formData = new FormData(e.target);
        this.showLoadingState(e.target.querySelector('button[type="submit"]'));
        
        // Simulate API call
        setTimeout(() => {
            this.showAlert('success', 'User berhasil diperbarui');
            this.hideModal('editUserModal');
            this.hideLoadingState(e.target.querySelector('button[type="submit"]'), 'Update User');
            this.updateUserInTable(formData);
        }, 1000);
    }

    handleChangePassword(e) {
        e.preventDefault();
        
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (!this.validatePasswordChange(newPassword, confirmPassword)) {
            return;
        }

        this.showLoadingState(e.target.querySelector('button[type="submit"]'));
        
        // Simulate API call
        setTimeout(() => {
            this.showAlert('success', 'Password berhasil diubah');
            this.hideModal('changePasswordModal');
            this.hideLoadingState(e.target.querySelector('button[type="submit"]'), 'Ubah Password');
        }, 1000);
    }

    // Validation Functions
    validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        return isValid;
    }

    validatePasswordChange(newPassword, confirmPassword) {
        let isValid = true;

        if (newPassword.length < 6) {
            document.getElementById('new_password').classList.add('is-invalid');
            this.showAlert('danger', 'Password minimal 6 karakter');
            isValid = false;
        }

        if (newPassword !== confirmPassword) {
            document.getElementById('confirm_password').classList.add('is-invalid');
            this.showAlert('danger', 'Konfirmasi password tidak sama');
            isValid = false;
        }

        return isValid;
    }

    validatePasswordMatch() {
        const newPassword = document.getElementById('new_password')?.value || '';
        const confirmPassword = document.getElementById('confirm_password')?.value || '';
        const confirmInput = document.getElementById('confirm_password');

        if (confirmInput && confirmPassword && newPassword !== confirmPassword) {
            confirmInput.classList.add('is-invalid');
        } else if (confirmInput) {
            confirmInput.classList.remove('is-invalid');
        }
    }

    // Password Strength
    updatePasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');
        
        if (!strengthBar || !strengthText) return;

        let strength = 0;
        let strengthLabel = '';
        let strengthClass = '';

        if (password.length >= 6) strength += 1;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

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

        const percentage = (strength / 4) * 100;
        strengthBar.style.width = percentage + '%';
        strengthBar.className = `progress-bar ${strengthClass}`;
        strengthText.textContent = password ? strengthLabel : 'Masukkan password untuk melihat kekuatan';
    }

    // UI Helper Functions
    showAlert(type, message) {
        const alertContainer = document.querySelector('.container-fluid') || document.body;
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show slide-up`;
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

    showLoadingState(button) {
        if (!button) return;
        button.disabled = true;
        button.classList.add('btn-loading');
        button.dataset.originalText = button.textContent;
        button.textContent = 'Memproses...';
    }

    hideLoadingState(button, originalText) {
        if (!button) return;
        button.disabled = false;
        button.classList.remove('btn-loading');
        button.textContent = originalText || button.dataset.originalText || 'Submit';
    }

    hideModal(modalId) {
        const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        if (modal) {
            modal.hide();
        }
    }

    resetModalForms(modal) {
        const forms = modal.querySelectorAll('form');
        forms.forEach(form => {
            form.reset();
            form.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
        });
    }

    // Table Management
    addUserToTable(formData) {
        // Implementation for adding user to table
        console.log('Adding user to table:', Object.fromEntries(formData));
    }

    updateUserInTable(formData) {
        // Implementation for updating user in table
        console.log('Updating user in table:', Object.fromEntries(formData));
    }

    performDeleteUser(userId, userRow) {
        const deleteBtn = userRow.querySelector('.btn-danger');
        
        if (deleteBtn) {
            this.showLoadingState(deleteBtn);
        }
        
        // Simulate API call
        setTimeout(() => {
            const userName = userRow.querySelector('.user-name')?.textContent || '';
            this.showAlert('success', `User "${userName}" berhasil dihapus`);
            
            // Remove row with animation
            userRow.style.transition = 'all 0.3s ease';
            userRow.style.opacity = '0';
            userRow.style.transform = 'translateX(100%)';
            
            setTimeout(() => {
                userRow.remove();
            }, 300);
        }, 1000);
    }

    // Password Toggle
    togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const button = input?.nextElementSibling;
        
        if (!input || !button) return;

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = 'Sembunyikan';
        } else {
            input.type = 'password';
            button.textContent = 'Lihat';
        }
    }

    // Additional Helper Functions
    changePassword(userId) {
        const userRow = document.querySelector(`[data-user-id="${userId}"]`);
        if (!userRow) return;
        
        this.currentUserId = userId;
        const userData = this.extractUserData(userRow);
        
        // Populate change password modal
        const avatar = document.getElementById('changePasswordAvatar');
        const name = document.getElementById('changePasswordUserName');
        const email = document.getElementById('changePasswordUserEmail');
        
        if (avatar) avatar.textContent = userData.name.substring(0, 2).toUpperCase();
        if (name) name.textContent = userData.name;
        if (email) email.textContent = userData.email;
        
        // Reset form and show modal
        const form = document.getElementById('changePasswordForm');
        if (form) {
            form.reset();
            form.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
        }
        
        this.updatePasswordStrength('');
        
        const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        modal.show();
    }

    editUserFromView() {
        this.hideModal('viewUserModal');
        setTimeout(() => {
            if (this.currentViewUserId) {
                this.editUser(this.currentViewUserId);
            }
        }, 300);
    }
}

// Global functions for backward compatibility
let userManager;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    userManager = new UserManagement();
});

// Global functions that can be called from HTML
function viewUser(userId) {
    userManager?.viewUser(userId);
}

function editUser(userId) {
    userManager?.editUser(userId);
}

function deleteUser(userId) {
    userManager?.deleteUser(userId);
}

function changePassword(userId) {
    userManager?.changePassword(userId);
}

function editUserFromView() {
    userManager?.editUserFromView();
}

function togglePasswordVisibility(inputId) {
    userManager?.togglePasswordVisibility(inputId);
}
