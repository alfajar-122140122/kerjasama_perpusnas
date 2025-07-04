/**
 * Public Website JavaScript
 * Perpustakaan Nasional RI - Portal Kerjasama
 */

// Global Variables
let isScrolled = false;
let lastScrollTop = 0;
let ticking = false;

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    initializePublicComponents();
});

// Initialize all public components
function initializePublicComponents() {
    initializeNavigation();
    initializeScrollEffects();
    initializeSearchFunctionality();
    initializeForms();
    initializeTooltips();
    initializeModals();
    initializeLazyLoading();
    initializeAnimations();
    initializeAccessibility();
    hideLoadingSpinner();
}

// Navigation Functions
function initializeNavigation() {
    const navbar = document.querySelector('.main-header');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    // Sticky Navigation
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    handleNavbarScroll(navbar);
                    ticking = false;
                });
                ticking = true;
            }
        });
    }
    
    // Mobile Navigation Toggle
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target)) {
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            }
        });
    }
    
    // Dropdown Hover Effect (Desktop only)
    if (window.innerWidth > 991) {
        initializeDropdownHover();
    }
    
    // Active Menu Highlighting
    highlightActiveMenu();
}

function handleNavbarScroll(navbar) {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 100 && !isScrolled) {
        navbar.classList.add('scrolled');
        isScrolled = true;
    } else if (scrollTop <= 100 && isScrolled) {
        navbar.classList.remove('scrolled');
        isScrolled = false;
    }
    
    // Hide/Show navbar on scroll
    if (scrollTop > lastScrollTop && scrollTop > 200) {
        // Scrolling down
        navbar.style.transform = 'translateY(-100%)';
    } else {
        // Scrolling up
        navbar.style.transform = 'translateY(0)';
    }
    
    lastScrollTop = scrollTop;
}

function initializeDropdownHover() {
    const dropdowns = document.querySelectorAll('.navbar-nav .dropdown');
    
    dropdowns.forEach(dropdown => {
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        let showTimeout, hideTimeout;
        
        dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hideTimeout);
            showTimeout = setTimeout(() => {
                const bsDropdown = new bootstrap.Dropdown(dropdown.querySelector('.dropdown-toggle'));
                bsDropdown.show();
            }, 100);
        });
        
        dropdown.addEventListener('mouseleave', function() {
            clearTimeout(showTimeout);
            hideTimeout = setTimeout(() => {
                const bsDropdown = bootstrap.Dropdown.getInstance(dropdown.querySelector('.dropdown-toggle'));
                if (bsDropdown) {
                    bsDropdown.hide();
                }
            }, 300);
        });
    });
}

function highlightActiveMenu() {
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href.replace(window.location.origin, ''))) {
            link.classList.add('active');
            
            // Also highlight parent dropdown if applicable
            const parentDropdown = link.closest('.dropdown');
            if (parentDropdown) {
                const dropdownToggle = parentDropdown.querySelector('.dropdown-toggle');
                if (dropdownToggle) {
                    dropdownToggle.classList.add('active');
                }
            }
        }
    });
}

// Scroll Effects
function initializeScrollEffects() {
    initializeBackToTop();
    initializeScrollAnimations();
    initializeParallaxEffects();
}

function initializeBackToTop() {
    const backToTopBtn = document.getElementById('btn-back-to-top');
    
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'block';
                setTimeout(() => {
                    backToTopBtn.style.opacity = '1';
                    backToTopBtn.style.transform = 'scale(1)';
                }, 10);
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    backToTopBtn.style.display = 'none';
                }, 300);
            }
        });
        
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            smoothScrollTo(0, 800);
        });
    }
}

function initializeScrollAnimations() {
    const animatedElements = document.querySelectorAll('[data-aos]');
    
    if (animatedElements.length > 0 && typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50,
            easing: 'ease-out-cubic'
        });
    }
    
    // Custom scroll animations for elements without AOS
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

function initializeParallaxEffects() {
    const parallaxElements = document.querySelectorAll('.parallax-element');
    
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    parallaxElements.forEach(element => {
                        const speed = element.dataset.speed || 0.5;
                        const yPos = -(window.pageYOffset * speed);
                        element.style.transform = `translateY(${yPos}px)`;
                    });
                    ticking = false;
                });
                ticking = true;
            }
        });
    }
}

// Search Functionality
function initializeSearchFunctionality() {
    const searchForms = document.querySelectorAll('.search-form, #searchForm');
    const searchModal = document.getElementById('searchModal');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    // Handle search form submissions
    searchForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const query = this.querySelector('input[type="text"], input[name="q"]').value.trim();
            if (query) {
                performSearch(query, searchResults);
            }
        });
    });
    
    // Real-time search in modal
    if (searchInput && searchResults) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length >= 3) {
                searchTimeout = setTimeout(() => {
                    performSearch(query, searchResults);
                }, 300);
            } else if (query.length === 0) {
                searchResults.innerHTML = '';
            }
        });
    }
    
    // Focus search input when modal is shown
    if (searchModal && searchInput) {
        searchModal.addEventListener('shown.bs.modal', function() {
            searchInput.focus();
        });
    }
}

async function performSearch(query, resultsContainer = null) {
    if (!resultsContainer) return;
    
    // Show loading state
    resultsContainer.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Mencari...</span>
            </div>
            <p class="mt-2 text-muted">Mencari "${query}"...</p>
        </div>
    `;
    
    try {
        const response = await fetch(`${window.location.origin}/api/search?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.results) {
            displaySearchResults(data.results, query, resultsContainer);
        } else {
            showNoResults(query, resultsContainer);
        }
    } catch (error) {
        console.error('Search error:', error);
        showSearchError(resultsContainer);
    }
}

function displaySearchResults(results, query, container) {
    if (results.length === 0) {
        showNoResults(query, container);
        return;
    }
    
    let html = `
        <div class="search-results">
            <h6 class="text-primary mb-3">Hasil Pencarian untuk "${query}" (${results.length} hasil)</h6>
    `;
    
    results.forEach(result => {
        html += `
            <div class="search-result-item border-bottom pb-3 mb-3">
                <h6 class="mb-1">
                    <a href="${result.url}" class="text-decoration-none">${highlightSearchTerm(result.title, query)}</a>
                </h6>
                <p class="text-muted small mb-1">${result.type} • ${formatDate(result.date)}</p>
                <p class="mb-0">${highlightSearchTerm(truncateText(result.excerpt, 120), query)}</p>
            </div>
        `;
    });
    
    html += `
            <div class="text-center mt-3">
                <a href="${window.location.origin}/pencarian?q=${encodeURIComponent(query)}" class="btn btn-primary btn-sm">
                    Lihat Semua Hasil
                </a>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
}

function showNoResults(query, container) {
    container.innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h6>Tidak ada hasil untuk "${query}"</h6>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda atau lebih umum</p>
        </div>
    `;
}

function showSearchError(container) {
    container.innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6>Terjadi kesalahan saat mencari</h6>
            <p class="text-muted">Silakan coba lagi dalam beberapa saat</p>
        </div>
    `;
}

// Form Handling
function initializeForms() {
    initializeContactForms();
    initializeNewsletterForm();
    initializeFormValidation();
    initializeFileUploads();
}

function initializeContactForms() {
    const contactForms = document.querySelectorAll('.contact-form, #contactForm');
    
    contactForms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(this.action || '/kontak/send', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', 'Pesan Anda berhasil dikirim. Kami akan segera merespons.');
                    this.reset();
                } else {
                    showAlert('error', data.message || 'Terjadi kesalahan saat mengirim pesan.');
                }
            } catch (error) {
                console.error('Contact form error:', error);
                showAlert('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    });
}

function initializeNewsletterForm() {
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Berlangganan...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch('/newsletter/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', 'Terima kasih! Anda telah berlangganan newsletter kami.');
                    this.reset();
                } else {
                    showAlert('error', data.message || 'Gagal berlangganan newsletter.');
                }
            } catch (error) {
                console.error('Newsletter error:', error);
                showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
}

function initializeFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    });
}

function validateField(field) {
    const isValid = field.checkValidity();
    
    field.classList.remove('is-valid', 'is-invalid');
    field.classList.add(isValid ? 'is-valid' : 'is-invalid');
    
    // Custom validation messages
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback && !isValid) {
        feedback.textContent = getValidationMessage(field);
    }
}

function getValidationMessage(field) {
    if (field.validity.valueMissing) {
        return `${field.getAttribute('data-label') || 'Field ini'} wajib diisi.`;
    }
    if (field.validity.typeMismatch) {
        return 'Format input tidak valid.';
    }
    if (field.validity.tooShort) {
        return `Minimal ${field.minLength} karakter.`;
    }
    if (field.validity.tooLong) {
        return `Maksimal ${field.maxLength} karakter.`;
    }
    if (field.validity.patternMismatch) {
        return field.getAttribute('data-pattern-message') || 'Format tidak sesuai.';
    }
    return 'Input tidak valid.';
}

function initializeFileUploads() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const files = Array.from(this.files);
            const maxSize = parseInt(this.getAttribute('data-max-size')) || 5242880; // 5MB default
            const allowedTypes = this.getAttribute('data-allowed-types')?.split(',') || [];
            
            let hasError = false;
            let errorMessage = '';
            
            files.forEach(file => {
                if (file.size > maxSize) {
                    hasError = true;
                    errorMessage = `File ${file.name} terlalu besar. Maksimal ${formatFileSize(maxSize)}.`;
                    return;
                }
                
                if (allowedTypes.length > 0 && !allowedTypes.includes(file.type)) {
                    hasError = true;
                    errorMessage = `File ${file.name} tidak didukung.`;
                    return;
                }
            });
            
            if (hasError) {
                showAlert('error', errorMessage);
                this.value = '';
                return;
            }
            
            // Show file preview if applicable
            showFilePreview(this, files);
        });
    });
}

function showFilePreview(input, files) {
    const previewContainer = input.parentNode.querySelector('.file-preview');
    if (!previewContainer) return;
    
    previewContainer.innerHTML = '';
    
    files.forEach(file => {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-preview-item d-flex align-items-center p-2 bg-light rounded mb-2';
        
        fileItem.innerHTML = `
            <i class="fas fa-file me-2"></i>
            <span class="flex-grow-1">${file.name}</span>
            <small class="text-muted">${formatFileSize(file.size)}</small>
        `;
        
        previewContainer.appendChild(fileItem);
    });
}

// Tooltips and Modals
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

function initializeModals() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const firstInput = this.querySelector('input, textarea, select');
            if (firstInput) {
                firstInput.focus();
            }
        });
        
        modal.addEventListener('hidden.bs.modal', function() {
            // Clear form validation states
            const forms = this.querySelectorAll('.was-validated');
            forms.forEach(form => {
                form.classList.remove('was-validated');
                const invalidInputs = form.querySelectorAll('.is-invalid, .is-valid');
                invalidInputs.forEach(input => {
                    input.classList.remove('is-invalid', 'is-valid');
                });
            });
        });
    });
}

// Lazy Loading
function initializeLazyLoading() {
    const lazyImages = document.querySelectorAll('img[data-src], iframe[data-src]');
    
    if (lazyImages.length > 0 && 'IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
        });
    }
}

// Animations
function initializeAnimations() {
    // Counter animations
    const counters = document.querySelectorAll('.counter');
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        });
        
        counters.forEach(counter => counterObserver.observe(counter));
    }
    
    // Stagger animations
    initializeStaggerAnimations();
}

function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = parseInt(element.getAttribute('data-duration')) || 2000;
    const start = parseInt(element.textContent) || 0;
    const startTime = performance.now();
    
    function updateCounter(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const current = Math.floor(start + (target - start) * easeOutCubic(progress));
        element.textContent = current.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        }
    }
    
    requestAnimationFrame(updateCounter);
}

function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
}

function initializeStaggerAnimations() {
    const staggerGroups = document.querySelectorAll('.stagger-animation');
    
    staggerGroups.forEach(group => {
        const items = group.querySelectorAll('.stagger-item');
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    items.forEach((item, index) => {
                        setTimeout(() => {
                            item.classList.add('animate-in');
                        }, index * 100);
                    });
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(group);
    });
}

// Accessibility
function initializeAccessibility() {
    // Skip to content link
    const skipLink = document.querySelector('.skip-to-content');
    if (skipLink) {
        skipLink.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.focus();
                target.scrollIntoView();
            }
        });
    }
    
    // Keyboard navigation for dropdowns
    initializeKeyboardNavigation();
    
    // Focus management
    initializeFocusManagement();
    
    // High contrast mode detection
    if (window.matchMedia('(prefers-contrast: high)').matches) {
        document.body.classList.add('high-contrast');
    }
    
    // Reduced motion detection
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.body.classList.add('reduced-motion');
    }
}

function initializeKeyboardNavigation() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        const items = menu ? menu.querySelectorAll('.dropdown-item') : [];
        
        if (toggle && menu && items.length > 0) {
            toggle.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!menu.classList.contains('show')) {
                        toggle.click();
                    }
                    setTimeout(() => items[0].focus(), 10);
                }
            });
            
            items.forEach((item, index) => {
                item.addEventListener('keydown', function(e) {
                    switch(e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            items[(index + 1) % items.length].focus();
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            items[(index - 1 + items.length) % items.length].focus();
                            break;
                        case 'Escape':
                            e.preventDefault();
                            toggle.click();
                            toggle.focus();
                            break;
                    }
                });
            });
        }
    });
}

function initializeFocusManagement() {
    // Focus trap for modals
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            trapFocus(this);
        });
    });
}

function trapFocus(element) {
    const focusableElements = element.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    
    element.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });
}

// Utility Functions
function smoothScrollTo(target, duration = 800) {
    const targetPosition = typeof target === 'number' ? target : target.offsetTop;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;
    
    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const run = easeInOutQuad(timeElapsed, startPosition, distance, duration);
        window.scrollTo(0, run);
        if (timeElapsed < duration) requestAnimationFrame(animation);
    }
    
    requestAnimationFrame(animation);
}

function easeInOutQuad(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t + b;
    t--;
    return -c / 2 * (t * (t - 2) - 1) + b;
}

function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = function() {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function truncateText(text, length) {
    if (text.length <= length) return text;
    return text.substr(0, length) + '...';
}

function highlightSearchTerm(text, term) {
    const regex = new RegExp(`(${term})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
}

function hideLoadingSpinner() {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) {
        spinner.style.opacity = '0';
        setTimeout(() => {
            spinner.style.display = 'none';
        }, 300);
    }
}

function showAlert(type, message, duration = 5000) {
    const alertContainer = document.getElementById('alert-container') || document.body;
    const alertId = 'alert-' + Date.now();
    
    const alertHtml = `
        <div id="${alertId}" class="alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    alertContainer.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto dismiss
    setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, duration);
}

// Public API
window.PublicJS = {
    smoothScrollTo,
    showAlert,
    formatDate,
    formatFileSize,
    debounce,
    throttle
};

// Handle unhandled promise rejections
window.addEventListener('unhandledrejection', function(event) {
    console.error('Unhandled promise rejection:', event.reason);
    showAlert('error', 'Terjadi kesalahan sistem. Silakan refresh halaman.');
});

// Service Worker registration (if available)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('SW registered: ', registration);
            })
            .catch(function(registrationError) {
                console.log('SW registration failed: ', registrationError);
            });
    });
}