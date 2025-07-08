document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterOptions = document.querySelectorAll('.filter-option');
    const newsCards = document.querySelectorAll('.news-card');
    
    filterOptions.forEach(function(option) {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all options
            filterOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');
            
            const filterValue = this.textContent.toLowerCase();
            
            // Filter news cards (in real implementation, this would be server-side)
            newsCards.forEach(function(card) {
                if (filterValue === 'semua') {
                    card.style.display = 'flex';
                } else {
                    // Simple filter logic - in real implementation, use data attributes
                    const category = card.querySelector('.news-category').textContent.toLowerCase();
                    const title = card.querySelector('.news-title').textContent.toLowerCase();
                    
                    if (title.includes(filterValue) || category.includes(filterValue)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
    
    // Animate news cards on scroll
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

    // Observe news cards
    newsCards.forEach(function(card, index) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Observe page title
    const pageTitle = document.querySelector('.page-title');
    if (pageTitle) {
        pageTitle.style.opacity = '0';
        pageTitle.style.transform = 'translateY(-20px)';
        pageTitle.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(pageTitle);
    }

    // Observe filter section
    const filterSection = document.querySelector('.filter-section');
    if (filterSection) {
        filterSection.style.opacity = '0';
        filterSection.style.transform = 'translateY(-10px)';
        filterSection.style.transition = 'opacity 0.6s ease 0.2s, transform 0.6s ease 0.2s';
        observer.observe(filterSection);
    }
});