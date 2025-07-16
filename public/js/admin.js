// Sidebar Toggle Function
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-toggle');
    
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    }
});

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('alert-dismissible')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 5000);
});

// Dashboard Animation
document.addEventListener('DOMContentLoaded', function() {
    const statsCards = document.querySelectorAll('.stats-card');
    
    // Add loading animation to stats cards
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100 + 200);
    });
    
    // Add loading animation to other cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        if (!card.classList.contains('stats-card')) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100 + 500);
        }
    });
});

// User Management Functions
function editUser(userId) {
    // TODO: Implement edit user functionality
    console.log('Edit user:', userId);
    alert('Edit user dengan ID: ' + userId);
}

function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
        // Show loading state
        const deleteBtn = document.querySelector(`button[onclick="deleteUser(${userId})"]`);
        const originalContent = deleteBtn.innerHTML;
        
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
        
        // Simulate API call
        fetch(`${window.location.origin}/admin/users/delete/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);
                // Remove row with animation
                const userRow = deleteBtn.closest('.user-row');
                userRow.style.transition = 'all 0.3s ease';
                userRow.style.opacity = '0';
                userRow.style.transform = 'translateX(100%)';
                
                setTimeout(() => {
                    userRow.remove();
                }, 300);
            } else {
                showAlert('danger', 'Gagal menghapus user: ' + data.message);
                deleteBtn.innerHTML = originalContent;
                deleteBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus user');
            deleteBtn.innerHTML = originalContent;
            deleteBtn.disabled = false;
        });
    }
}

// Show alert function
function showAlert(type, message) {
    const alertContainer = document.querySelector('.content-area');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
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

// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    // Remove invalid class after user starts typing
                    field.addEventListener('input', function() {
                        this.classList.remove('is-invalid');
                    });
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showAlert('danger', 'Mohon lengkapi semua field yang diperlukan!');
            }
        });
    });
});

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Add ripple effect to buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add ripple effect CSS
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyle);

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle - Fixed Implementation
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    
    function isMobile() {
        return window.innerWidth <= 768;
    }
    
    function toggleSidebar() {
        const wrapper = document.querySelector('.wrapper');
        
        if (isMobile()) {
            // Mobile: Show/Hide sidebar completely
            sidebar.classList.toggle('show');
            
            // Add/remove body overlay
            if (sidebar.classList.contains('show')) {
                document.body.classList.add('sidebar-open');
                if (!document.querySelector('.sidebar-overlay')) {
                    const overlay = document.createElement('div');
                    overlay.className = 'sidebar-overlay';
                    document.body.appendChild(overlay);
                    
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        document.body.classList.remove('sidebar-open');
                        overlay.remove();
                    });
                }
            } else {
                document.body.classList.remove('sidebar-open');
                const overlay = document.querySelector('.sidebar-overlay');
                if (overlay) overlay.remove();
            }
        } else {
            // Desktop: Completely Hide/Show sidebar
            sidebar.classList.toggle('collapsed');
            wrapper.classList.toggle('sidebar-collapsed');
        }
    }
    
    if (sidebarCollapse && sidebar) {
        sidebarCollapse.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });
    }
    
    // Close sidebar when clicking outside (mobile only)
    document.addEventListener('click', function(e) {
        if (isMobile() && sidebar && sidebar.classList.contains('show')) {
            if (!sidebar.contains(e.target) && !sidebarCollapse.contains(e.target)) {
                sidebar.classList.remove('show');
                document.body.classList.remove('sidebar-open');
                const overlay = document.querySelector('.sidebar-overlay');
                if (overlay) overlay.remove();
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const wrapper = document.querySelector('.wrapper');
        
        if (!isMobile()) {
            // Remove mobile classes when switching to desktop
            sidebar.classList.remove('show');
            document.body.classList.remove('sidebar-open');
            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) overlay.remove();
        } else {
            // Remove desktop classes when switching to mobile
            sidebar.classList.remove('collapsed');
            wrapper.classList.remove('sidebar-collapsed');
        }
    });
    
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        if (alert.classList.contains('alert-success')) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    });
    
    // Animate cards on scroll
    function animateOnScroll() {
        const cards = document.querySelectorAll('.stats-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
    
    // Start animations
    setTimeout(animateOnScroll, 200);
    
    // Real-time clock
    function updateClock() {
        const clockElements = document.querySelectorAll('[data-clock]');
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const timeString = now.toLocaleDateString('id-ID', options);
        
        clockElements.forEach(element => {
            element.textContent = timeString;
        });
    }
    
    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call
});

document.addEventListener('DOMContentLoaded', function() {
    // Users dropdown with smooth toggle
    const usersToggle = document.querySelector('a[data-target="usersSubmenu"]');
    const usersSubmenu = document.getElementById('usersSubmenu');

    if (usersToggle && usersSubmenu) {
        usersToggle.addEventListener('click', function(e) {
            e.preventDefault();

            const isOpen = usersSubmenu.classList.contains('open');

            if (isOpen) {
                usersSubmenu.classList.remove('open');
                usersToggle.classList.remove('expanded');
            } else {
                usersSubmenu.classList.add('open');
                usersToggle.classList.add('expanded');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Kerjasama dropdown with smooth toggle
    const kerjasamaToggle = document.querySelector('a[data-target="kerjasamaSubmenu"]');
    const kerjasamaSubmenu = document.getElementById('kerjasamaSubmenu');
    
    if (kerjasamaToggle && kerjasamaSubmenu) {
        kerjasamaToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isOpen = kerjasamaSubmenu.classList.contains('open');
            
            if (isOpen) {
                kerjasamaSubmenu.classList.remove('open');
                kerjasamaToggle.classList.remove('expanded');
            } else {
                kerjasamaSubmenu.classList.add('open');
                kerjasamaToggle.classList.add('expanded');
            }
        });
    }
});