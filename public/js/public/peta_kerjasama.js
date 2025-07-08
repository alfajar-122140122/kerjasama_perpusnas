document.addEventListener('DOMContentLoaded', function() {
    // Partner Slider functionality
    const slider = document.getElementById('partnerSlider');
    const slides = document.querySelectorAll('.partner-slide');
    const indicatorsContainer = document.getElementById('sliderIndicators');
    
    let currentSlide = 0;
    const slidesToShow = window.innerWidth >= 768 ? 4 : window.innerWidth >= 576 ? 3 : 2;
    const totalSlides = slides.length;
    const maxSlides = Math.max(0, totalSlides - slidesToShow);
    
    // Generate indicators
    for (let i = 0; i <= maxSlides; i++) {
        const indicator = document.createElement('div');
        indicator.className = 'indicator';
        if (i === 0) indicator.classList.add('active');
        indicator.addEventListener('click', () => goToSlide(i));
        indicatorsContainer.appendChild(indicator);
    }
    
    const indicators = document.querySelectorAll('.indicator');
    
    function updateSlider() {
        const slideWidth = slides[0].offsetWidth + 24; // including gap
        slider.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        
        // Update indicators
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });
    }
    
    function goToSlide(slideIndex) {
        currentSlide = Math.max(0, Math.min(slideIndex, maxSlides));
        updateSlider();
    }
    
    function nextSlide() {
        if (currentSlide < maxSlides) {
            currentSlide++;
        } else {
            currentSlide = 0; // Loop back to first slide
        }
        updateSlider();
    }
    
    // AUTO-SLIDE SETIAP 3 DETIK
    let autoSlideInterval = setInterval(nextSlide, 3000);
    
    // Pause auto-slide when hovering over slider
    slider.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });
    
    // Resume auto-slide when mouse leaves
    slider.addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(nextSlide, 3000);
    });
    
    // Manual navigation via indicators (pause auto-slide temporarily)
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            clearInterval(autoSlideInterval);
            goToSlide(index);
            // Resume auto-slide after 5 seconds
            setTimeout(() => {
                autoSlideInterval = setInterval(nextSlide, 3000);
            }, 5000);
        });
    });
    
    // Initial update
    updateSlider();
    
    // Filter functionality for map markers
    const filterButtons = document.querySelectorAll('.filter-btn');
    const markers = document.querySelectorAll('.marker');
    const partnerSlides = document.querySelectorAll('.partner-slide');
    const searchInput = document.getElementById('searchPartner');
    
    // Filter by type
    filterButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterType = this.getAttribute('data-filter');
            
            // Filter map markers
            markers.forEach(function(marker) {
                if (filterType === 'all') {
                    marker.style.display = 'flex';
                } else {
                    if (marker.getAttribute('data-type') === filterType) {
                        marker.style.display = 'flex';
                    } else {
                        marker.style.display = 'none';
                    }
                }
            });
            
            // Filter slider items
            partnerSlides.forEach(function(slide) {
                if (filterType === 'all') {
                    slide.style.display = 'block';
                } else {
                    if (slide.getAttribute('data-type') === filterType) {
                        slide.style.display = 'block';
                    } else {
                        slide.style.display = 'none';
                    }
                }
            });
            
            // Reset slider position and restart auto-slide
            currentSlide = 0;
            updateSlider();
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 3000);
        });
    });
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            partnerSlides.forEach(function(slide) {
                const partnerName = slide.querySelector('.partner-name').textContent.toLowerCase();
                const partnerLocation = slide.querySelector('.partner-location').textContent.toLowerCase();
                
                if (partnerName.includes(searchTerm) || partnerLocation.includes(searchTerm)) {
                    slide.style.display = 'block';
                } else {
                    slide.style.display = 'none';
                }
            });
            
            // Reset slider position and restart auto-slide
            currentSlide = 0;
            updateSlider();
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 3000);
        });
    }
    
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements
    const pageTitle = document.querySelector('.page-title');
    const mapWrapper = document.querySelector('.map-wrapper');
    const partnerSection = document.querySelector('.partner-section');

    [pageTitle, mapWrapper, partnerSection].forEach(element => {
        if (element) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(element);
        }
    });
    
    // Responsive slider update
    window.addEventListener('resize', function() {
        const newSlidesToShow = window.innerWidth >= 768 ? 4 : window.innerWidth >= 576 ? 3 : 2;
        if (newSlidesToShow !== slidesToShow) {
            location.reload(); // Simple solution for responsive changes
        }
    });
});