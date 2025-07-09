// Auto dismiss success alerts
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss alerts after 5 seconds
    document.querySelectorAll('.alert-success').forEach(alert => {
        setTimeout(() => {
            if (bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    
    // Input focus animations
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'all 0.3s ease';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
        
        // Add success state on valid input
        input.addEventListener('input', function() {
            if (this.value.length > 0 && this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Smooth entrance animation
    const formCard = document.querySelector('.auth-form-section');
    const brandTitle = document.querySelector('.brand-title');
    
    if (formCard) {
        formCard.style.opacity = '0';
        formCard.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            formCard.style.transition = 'all 0.6s ease-out';
            formCard.style.opacity = '1';
            formCard.style.transform = 'translateY(0)';
        }, 200);
    }
    
    if (brandTitle) {
        brandTitle.style.opacity = '0';
        brandTitle.style.transform = 'translateX(-30px)';
        
        setTimeout(() => {
            brandTitle.style.transition = 'all 0.8s ease-out';
            brandTitle.style.opacity = '1';
            brandTitle.style.transform = 'translateX(0)';
        }, 100);
    }
});

// Form validation
document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    const username = document.querySelector('input[name="username"]').value;
    const password = document.querySelector('input[name="password"]').value;
    
    if (!username.trim() || !password.trim()) {
        e.preventDefault();
        
        // Show inline validation
        if (!username.trim()) {
            const usernameField = document.querySelector('input[name="username"]');
            usernameField.classList.add('is-invalid');
            usernameField.focus();
        }
        
        if (!password.trim()) {
            const passwordField = document.querySelector('input[name="password"]');
            passwordField.classList.add('is-invalid');
        }
        
        return false;
    }
});

// Toggle Password Visibility
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

// Remove validation classes on input
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});

// Simple hover effect for form card
const formCard = document.querySelector('.auth-form-section');
if (formCard) {
    formCard.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.transition = 'all 0.3s ease';
    });
    
    formCard.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
}