// Header search functionality
function performHeaderSearch() {
    const searchInput = document.getElementById('headerSearchInput');
    const query = searchInput.value.trim();
    
    if (query) {
        window.location.href = `${window.location.origin}/pencarian?q=${encodeURIComponent(query)}`;
    }
}

// Enter key search
document.getElementById('headerSearchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performHeaderSearch();
    }
});

// Enhanced navigation with dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const homeIcon = document.querySelector('.home-icon-link');
    const dropdownToggles = document.querySelectorAll('.nav-dropdown-toggle');
    
    // Initialize dropdown functionality
    initializeDropdowns();
    
    // Add smooth hover effects
    navLinks.forEach(link => {
        if (!link.classList.contains('nav-dropdown-toggle')) {
            link.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(-1px)';
                    this.style.transition = 'transform 0.2s ease';
                }
            });
            
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(0)';
                }
            });
        }
    });
    
    // Home icon hover effect
    if (homeIcon) {
        homeIcon.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        homeIcon.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    }
    
    function initializeDropdowns() {
        dropdownToggles.forEach(toggle => {
            const dropdown = toggle.closest('.nav-dropdown');
            const menu = dropdown.querySelector('.nav-dropdown-menu');
            let hoverTimeout;
            
            // Prevent default link behavior
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleDropdown(dropdown);
            });
            
            // Show dropdown on hover (desktop)
            dropdown.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                if (window.innerWidth > 768) {
                    showDropdown(dropdown);
                }
            });
            
            // Hide dropdown on mouse leave with delay
            dropdown.addEventListener('mouseleave', function() {
                if (window.innerWidth > 768) {
                    hoverTimeout = setTimeout(() => {
                        hideDropdown(dropdown);
                    }, 200);
                }
            });
            
            // Handle dropdown item clicks
            const dropdownItems = dropdown.querySelectorAll('.nav-dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    hideDropdown(dropdown);
                });
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-dropdown')) {
                closeAllDropdowns();
            }
        });
    }
    
    function toggleDropdown(dropdown) {
        const isOpen = dropdown.classList.contains('show');
        closeAllDropdowns();
        
        if (!isOpen) {
            showDropdown(dropdown);
        }
    }
    
    function showDropdown(dropdown) {
        const menu = dropdown.querySelector('.nav-dropdown-menu');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        
        dropdown.classList.add('show');
        menu.style.display = 'block';
        
        setTimeout(() => {
            menu.style.opacity = '1';
            menu.style.transform = 'translateY(0)';
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }, 10);
    }
    
    function hideDropdown(dropdown) {
        const menu = dropdown.querySelector('.nav-dropdown-menu');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        
        menu.style.opacity = '0';
        menu.style.transform = 'translateY(-10px)';
        if (arrow) {
            arrow.style.transform = 'rotate(0deg)';
        }
        
        setTimeout(() => {
            dropdown.classList.remove('show');
            menu.style.display = 'none';
        }, 300);
    }
    
    function closeAllDropdowns() {
        document.querySelectorAll('.nav-dropdown.show').forEach(dropdown => {
            hideDropdown(dropdown);
        });
    }
    
    // Debug current page detection
    console.log('Current URI:', '<?= uri_string() ?>');
    console.log('Active nav detected for:', 
        document.querySelector('.nav-link.active')?.textContent.trim() || 'Home');
});