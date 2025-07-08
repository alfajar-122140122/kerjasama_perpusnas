document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const subjek = document.getElementById('subjek').value.trim();
            const pesan = document.getElementById('pesan').value.trim();
            
            if (!nama || !email || !subjek || !pesan) {
                alert('Mohon isi semua field yang wajib diisi (*)');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(function() {
                alert('Pesan berhasil dikirim! Kami akan segera merespons.');
                contactForm.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
    
    // Animate contact info on scroll
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

    // Observe contact details
    const contactDetails = document.querySelectorAll('.contact-detail');
    contactDetails.forEach(function(detail, index) {
        detail.style.opacity = '0';
        detail.style.transform = 'translateY(20px)';
        detail.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(detail);
    });

    // Observe map container
    const mapContainer = document.querySelector('.map-container');
    if (mapContainer) {
        mapContainer.style.opacity = '0';
        mapContainer.style.transform = 'translateX(-30px)';
        mapContainer.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(mapContainer);
    }

    // Observe contact info
    const contactInfo = document.querySelector('.contact-info');
    if (contactInfo) {
        contactInfo.style.opacity = '0';
        contactInfo.style.transform = 'translateX(30px)';
        contactInfo.style.transition = 'opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s';
        observer.observe(contactInfo);
    }
});