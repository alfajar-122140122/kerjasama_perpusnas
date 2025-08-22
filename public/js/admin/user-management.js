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

// User Pagination Class
class UserPagination {
    constructor() {
        this.currentPage = 1;
        this.itemsPerPage = 10;
        this.totalUsers = 0;
        this.totalPages = 1;
        this.allUsers = [];
        
        this.init();
    }
    
    init() {
        this.extractUserData();
        this.createPaginationInterface();
        this.setupEventListeners();
        this.updateDisplay();
    }
    
    extractUserData() {
        const userRows = document.querySelectorAll('.user-row');
        this.allUsers = Array.from(userRows);
        this.totalUsers = this.allUsers.length;
        this.calculateTotalPages();
    }
    
    calculateTotalPages() {
        this.totalPages = Math.ceil(this.totalUsers / this.itemsPerPage);
        if (this.totalPages === 0) this.totalPages = 1;
    }
    
    createPaginationInterface() {
        const cardBody = document.querySelector('.card-body');
        
        // Create pagination container
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'pagination-container';
        paginationContainer.id = 'userPaginationContainer';
        
        paginationContainer.innerHTML = `
            <div class="pagination-info">
                <div class="pagination-info-text" id="paginationInfoText">
                    Menampilkan 1 - ${Math.min(this.itemsPerPage, this.totalUsers)} dari ${this.totalUsers} user
                </div>
                <div class="pagination-controls">
                    <label for="itemsPerPage" class="form-label mb-0 me-2">Tampilkan:</label>
                    <select class="pagination-select" id="itemsPerPage">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="ms-2">per halaman</span>
                </div>
            </div>
            <nav aria-label="User pagination">
                <ul class="pagination justify-content-center mb-0" id="userPagination">
                    <!-- Pagination buttons will be inserted here -->
                </ul>
            </nav>
        `;
        
        cardBody.appendChild(paginationContainer);
    }
    
    setupEventListeners() {
        // Items per page selector
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        if (itemsPerPageSelect) {
            itemsPerPageSelect.addEventListener('change', (e) => {
                this.itemsPerPage = parseInt(e.target.value);
                this.currentPage = 1;
                this.calculateTotalPages();
                this.updateDisplay();
            });
        }
    }
    
    updateDisplay() {
        this.showCurrentPageUsers();
        this.updatePaginationButtons();
        this.updateInfoText();
    }
    
    showCurrentPageUsers() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        
        // Hide all users first
        this.allUsers.forEach(userRow => {
            userRow.style.display = 'none';
        });
        
        // Show current page users
        const currentPageUsers = this.allUsers.slice(startIndex, endIndex);
        currentPageUsers.forEach(userRow => {
            userRow.style.display = '';
        });
        
        // Handle empty state
        this.handleEmptyState(currentPageUsers.length === 0 && this.totalUsers > 0);
    }
    
    handleEmptyState(isEmpty) {
        let emptyRow = document.querySelector('.empty-pagination-row');
        
        if (isEmpty) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-pagination-row';
                emptyRow.innerHTML = `
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada user pada halaman ini
                    </td>
                `;
                document.querySelector('tbody').appendChild(emptyRow);
            }
        } else {
            if (emptyRow) {
                emptyRow.remove();
            }
        }
    }
    
    updatePaginationButtons() {
        const paginationContainer = document.getElementById('userPagination');
        if (!paginationContainer) return;
        
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `
            <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="userPagination.goToPage(${this.currentPage - 1})" ${this.currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
            </li>
        `;
        
        // Page numbers
        const maxVisiblePages = 5;
        let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(this.totalPages, startPage + maxVisiblePages - 1);
        
        // Adjust start page if we're near the end
        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        // First page
        if (startPage > 1) {
            paginationHTML += `
                <li class="page-item">
                    <button class="page-link" onclick="userPagination.goToPage(1)">1</button>
                </li>
            `;
            if (startPage > 2) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        // Page numbers in range
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                    <button class="page-link" onclick="userPagination.goToPage(${i})">${i}</button>
                </li>
            `;
        }
        
        // Last page
        if (endPage < this.totalPages) {
            if (endPage < this.totalPages - 1) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            paginationHTML += `
                <li class="page-item">
                    <button class="page-link" onclick="userPagination.goToPage(${this.totalPages})">${this.totalPages}</button>
                </li>
            `;
        }
        
        // Next button
        paginationHTML += `
            <li class="page-item ${this.currentPage === this.totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="userPagination.goToPage(${this.currentPage + 1})" ${this.currentPage === this.totalPages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        `;
        
        paginationContainer.innerHTML = paginationHTML;
    }
    
    updateInfoText() {
        const infoTextElement = document.getElementById('paginationInfoText');
        if (!infoTextElement) return;
        
        const startIndex = (this.currentPage - 1) * this.itemsPerPage + 1;
        const endIndex = Math.min(this.currentPage * this.itemsPerPage, this.totalUsers);
        
        if (this.totalUsers === 0) {
            infoTextElement.textContent = 'Tidak ada user';
        } else {
            infoTextElement.textContent = `Menampilkan ${startIndex} - ${endIndex} dari ${this.totalUsers} user`;
        }
    }
    
    goToPage(page) {
        if (page < 1 || page > this.totalPages) return;
        
        this.currentPage = page;
        this.updateDisplay();
        
        // Scroll to top of table
        document.querySelector('.card').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }
    
    refresh() {
        // Re-extract user data after add/delete operations
        this.extractUserData();
        
        // Adjust current page if necessary
        if (this.currentPage > this.totalPages) {
            this.currentPage = Math.max(1, this.totalPages);
        }
        
        this.calculateTotalPages();
        this.updateDisplay();
    }
    
    addUser(userElement) {
        // Add new user to the list
        this.allUsers.push(userElement);
        this.totalUsers++;
        this.calculateTotalPages();
        
        // Go to the page where the new user would be
        const newUserPage = Math.ceil(this.totalUsers / this.itemsPerPage);
        this.goToPage(newUserPage);
    }
    
    removeUser(userId) {
        // Remove user from the list
        this.allUsers = this.allUsers.filter(userRow => 
            userRow.getAttribute('data-user-id') !== userId.toString()
        );
        this.totalUsers--;
        this.calculateTotalPages();
        
        // Adjust current page if necessary
        if (this.currentPage > this.totalPages) {
            this.currentPage = Math.max(1, this.totalPages);
        }
        
        this.updateDisplay();
    }
}

// Initialize pagination when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if there are users before initializing pagination
    const userRows = document.querySelectorAll('.user-row');
    
    if (userRows.length > 0) {
        window.userPagination = new UserPagination();
    }
});

// Refresh pagination after user operations
const originalAddUserSuccess = window.addUserSuccess || function() {};
window.addUserSuccess = function(response) {
    originalAddUserSuccess(response);
    
    if (window.userPagination) {
        // Wait for DOM to update then refresh pagination
        setTimeout(() => {
            window.userPagination.refresh();
        }, 100);
    }
};

const originalDeleteUserSuccess = window.deleteUserSuccess || function() {};
window.deleteUserSuccess = function(userId) {
    originalDeleteUserSuccess(userId);
    
    if (window.userPagination) {
        window.userPagination.removeUser(userId);
    }
};

// Initialize pagination if users are added dynamically
function initializePaginationIfNeeded() {
    const userRows = document.querySelectorAll('.user-row');
    
    if (userRows.length > 0 && !window.userPagination) {
        window.userPagination = new UserPagination();
    } else if (userRows.length === 0 && window.userPagination) {
        // Remove pagination if no users
        const paginationContainer = document.getElementById('userPaginationContainer');
        if (paginationContainer) {
            paginationContainer.remove();
        }
        window.userPagination = null;
    }
}

// Monitor for dynamic changes
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'childList') {
            const hasUserChanges = Array.from(mutation.addedNodes).some(node => 
                node.classList && node.classList.contains('user-row')
            ) || Array.from(mutation.removedNodes).some(node => 
                node.classList && node.classList.contains('user-row')
            );
            
            if (hasUserChanges) {
                setTimeout(initializePaginationIfNeeded, 100);
            }
        }
    });
});

// Start observing
const tbody = document.querySelector('tbody');
if (tbody) {
    observer.observe(tbody, { childList: true });
}