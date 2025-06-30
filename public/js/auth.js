document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginButton = loginForm.querySelector('.btn-login');
    
    // Form submission handling
    loginForm.addEventListener('submit', function(e) {
        // Show loading state
        const originalText = loginButton.textContent;
        loginButton.textContent = 'Memproses...';
        loginButton.disabled = true;
        
        // Reset button after 3 seconds if no redirect happens
        setTimeout(() => {
            loginButton.textContent = originalText;
            loginButton.disabled = false;
        }, 3000);
    });
    
    // Input focus effects
    const inputs = document.querySelectorAll('.login-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentNode.classList.remove('focused');
        });
    });
});