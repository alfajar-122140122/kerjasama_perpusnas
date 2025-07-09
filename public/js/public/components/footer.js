// Footer Scripts

// Back to top button functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeBackToTop();
    initializeFooterAnimations();
});

function initializeBackToTop() {
    const backToTopButton = document.getElementById('btn-back-to-top');
    
    if (backToTopButton) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'block';
                backToTopButton.style.opacity = '1';
            } else {
                backToTopButton.style.opacity = '0';
                setTimeout(() => {
                    if (window.pageYOffset <= 300) {
                        backToTopButton.style.display = 'none';
                    }
                }, 300);
            }
        });
        
        // Smooth scroll to top
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Keyboard accessibility
        backToTopButton.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    }
}

function initializeFooterAnimations() {
    // Intersection Observer untuk animasi footer
    const footerSections = document.querySelectorAll('.footer-section');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    footerSections.forEach(section => {
        observer.observe(section);
    });
}

// Additional footer functionality
function handleFooterLinks() {
    // Add click tracking for footer links (analytics)
    const footerLinks = document.querySelectorAll('.footer-section a');
    
    footerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Track link clicks for analytics
            const linkText = this.textContent.trim();
            const section = this.closest('.footer-section').querySelector('h5').textContent;
            
            // Example: Send to analytics
            console.log(`Footer link clicked: ${linkText} in ${section} section`);
        });
    });
}

// Initialize additional functionality
document.addEventListener('DOMContentLoaded', function() {
    handleFooterLinks();
});