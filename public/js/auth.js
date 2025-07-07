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
            this.closest('.input-group').style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.closest('.input-group').style.transform = 'translateY(0)';
        });
    });
});

// Form validation
document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    const username = document.querySelector('input[name="username"]').value;
    const password = document.querySelector('input[name="password"]').value;
    
    if (!username.trim() || !password.trim()) {
        e.preventDefault();
        alert('Username dan Password harus diisi!');
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