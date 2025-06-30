// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

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