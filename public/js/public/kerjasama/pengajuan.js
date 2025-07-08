class PengajuanKerjasamaManager {
    constructor() {
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.setupFileUpload();
    }
    
    bindEvents() {
        const form = document.getElementById('pengajuanForm');
        const resetBtn = document.getElementById('resetBtn');
        
        // Form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });
        
        // Reset form
        resetBtn.addEventListener('click', () => {
            this.resetForm();
        });
        
        // Phone number formatting
        const telInput = document.getElementById('telp');
        telInput.addEventListener('input', this.formatPhoneNumber);
        
        // Real-time validation
        this.setupFormValidation();
    }
    
    setupFileUpload() {
        const fileInput = document.getElementById('formulir');
        const fileLabel = document.querySelector('.pengajuan-file-label');
        const filePreview = document.getElementById('filePreview');
        
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                this.showFilePreview(file);
            }
        });
        
        // Drag and drop functionality
        fileLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileLabel.style.borderColor = '#007bff';
            fileLabel.style.backgroundColor = '#e3f2fd';
        });
        
        fileLabel.addEventListener('dragleave', (e) => {
            e.preventDefault();
            fileLabel.style.borderColor = '#dee2e6';
            fileLabel.style.backgroundColor = '#f8f9fa';
        });
        
        fileLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            fileLabel.style.borderColor = '#dee2e6';
            fileLabel.style.backgroundColor = '#f8f9fa';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                this.showFilePreview(files[0]);
            }
        });
    }
    
    showFilePreview(file) {
        const filePreview = document.getElementById('filePreview');
        const fileName = filePreview.querySelector('.pengajuan-file-name');
        const fileLabel = document.querySelector('.pengajuan-file-label');
        
        // Validate file
        if (!this.validateFile(file)) {
            return;
        }
        
        fileName.textContent = file.name;
        filePreview.style.display = 'flex';
        fileLabel.style.display = 'none';
    }
    
    validateFile(file) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if (file.size > maxSize) {
            this.showAlert('File terlalu besar. Maksimal 5MB.', 'error');
            return false;
        }
        
        if (!allowedTypes.includes(file.type)) {
            this.showAlert('Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.', 'error');
            return false;
        }
        
        return true;
    }
    
    formatPhoneNumber(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Format for Indonesian phone numbers
        if (value.startsWith('62')) {
            value = '+' + value;
        } else if (value.startsWith('0')) {
            value = value.replace(/^0/, '');
            if (value.length >= 2) {
                value = value.replace(/(\d{2,3})(\d{0,8})/, '$1-$2');
            }
            value = '0' + value;
        }
        
        e.target.value = value;
    }
    
    setupFormValidation() {
        const inputs = document.querySelectorAll('.pengajuan-form-input, .pengajuan-form-textarea');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                if (input.classList.contains('is-invalid')) {
                    this.validateField(input);
                }
            });
        });
    }
    
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';
        
        // Required validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            message = 'Field ini wajib diisi';
        }
        
        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                message = 'Format email tidak valid';
            }
        }
        
        // Phone validation
        if (field.type === 'tel' && value) {
            const phoneRegex = /^[\d\-\+\(\)\s]+$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                message = 'Format nomor telepon tidak valid';
            }
        }
        
        this.showFieldValidation(field, isValid, message);
        return isValid;
    }
    
    showFieldValidation(field, isValid, message) {
        const existingError = field.parentNode.querySelector('.field-error');
        
        if (existingError) {
            existingError.remove();
        }
        
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error';
            errorDiv.style.color = '#dc3545';
            errorDiv.style.fontSize = '0.8rem';
            errorDiv.style.marginTop = '5px';
            errorDiv.textContent = message;
            
            field.parentNode.appendChild(errorDiv);
        }
    }
    
    handleSubmit() {
        const form = document.getElementById('pengajuanForm');
        const formData = new FormData(form);
        
        // Validate all fields
        const inputs = form.querySelectorAll('.pengajuan-form-input, .pengajuan-form-textarea');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        // Validate file upload
        const fileInput = document.getElementById('formulir');
        if (!fileInput.files.length) {
            this.showAlert('Silakan upload formulir terlebih dahulu.', 'error');
            isFormValid = false;
        }
        
        if (!isFormValid) {
            this.showAlert('Mohon periksa kembali form Anda.', 'error');
            return;
        }
        
        // Show loading
        this.showLoading(true);
        
        // Simulate API call
        setTimeout(() => {
            this.showLoading(false);
            this.showSuccessModal();
            this.resetForm();
        }, 2000);
    }
    
    resetForm() {
        const form = document.getElementById('pengajuanForm');
        form.reset();
        
        // Reset file upload
        this.removeFile();
        
        // Clear validation classes
        const inputs = form.querySelectorAll('.pengajuan-form-input, .pengajuan-form-textarea');
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
        
        // Remove error messages
        const errors = form.querySelectorAll('.field-error');
        errors.forEach(error => error.remove());
        
        // Reset radio to default
        document.getElementById('jenis_baru').checked = true;
    }
    
    showLoading(show) {
        const submitBtn = document.getElementById('submitBtn');
        const resetBtn = document.getElementById('resetBtn');
        
        if (show) {
            submitBtn.disabled = true;
            resetBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        } else {
            submitBtn.disabled = false;
            resetBtn.disabled = false;
            submitBtn.innerHTML = 'Submit';
        }
    }
    
    showSuccessModal() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'flex';
        
        // Auto close after 5 seconds
        setTimeout(() => {
            this.closeModal();
        }, 5000);
    }
    
    closeModal() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'none';
    }
    
    showAlert(message, type = 'info') {
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `pengajuan-alert pengajuan-alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="alert-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add styles
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'error' ? '#f8d7da' : '#d4edda'};
            color: ${type === 'error' ? '#721c24' : '#155724'};
            border: 1px solid ${type === 'error' ? '#f5c6cb' : '#c3e6cb'};
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1001;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 400px;
        `;
        
        document.body.appendChild(alert);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }
}

// Global functions for inline event handlers
function removeFile() {
    const fileInput = document.getElementById('formulir');
    const filePreview = document.getElementById('filePreview');
    const fileLabel = document.querySelector('.pengajuan-file-label');
    
    fileInput.value = '';
    filePreview.style.display = 'none';
    fileLabel.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'none';
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new PengajuanKerjasamaManager();
});