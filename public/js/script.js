/**
 * Main JavaScript for Kerjasama Perpusnas Website
 * Version: 1.0
 */

$(document).ready(function() {
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === "#") return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Activate Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Activate Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Animated counter for statistics
    function animateCounter() {
        $('.stat-number').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    }
    
    // Check if element is in viewport
    function isInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    // Trigger counter animation when stats section is in viewport
    let animationTriggered = false;
    $(window).on('scroll', function() {
        if (!animationTriggered && $('.stats-section').length) {
            if (isInViewport(document.querySelector('.stats-section'))) {
                animateCounter();
                animationTriggered = true;
            }
        }
    });
    
    // Trigger initially if stats section is already visible
    if ($('.stats-section').length && isInViewport(document.querySelector('.stats-section'))) {
        animateCounter();
        animationTriggered = true;
    }
    
    // Form validation
    if ($('.needs-validation').length) {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    }
    
    // File input custom styling
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Initialize cooperation map if exists
    if ($('#cooperation-map').length) {
        initCooperationMap();
    }
    
    // Initialize cooperation data filters
    if ($('.filter-btn').length) {
        $('.filter-btn').click(function() {
            const filterValue = $(this).data('filter');
            
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            if (filterValue === 'all') {
                $('.cooperation-card').show();
            } else {
                $('.cooperation-card').hide();
                $(`.cooperation-card[data-category="${filterValue}"]`).show();
            }
        });
    }
});

// Map initialization function
function initCooperationMap() {
    // Initialize map
    const map = L.map('cooperation-map').setView([-2.5489, 118.0149], 5);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Fetch map data from API
    $.ajax({
        url: base_url + 'api/cooperation/map-data',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                addMarkers(map, response.data);
            }
        },
        error: function() {
            console.error('Failed to fetch map data');
        }
    });
}

// Add markers to map
function addMarkers(map, markers) {
    // Define marker icons for different types
    const icons = {
        'MOU': L.icon({
            iconUrl: base_url + 'images/markers/marker-blue.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }),
        'PKS': L.icon({
            iconUrl: base_url + 'images/markers/marker-green.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }),
        'NKB': L.icon({
            iconUrl: base_url + 'images/markers/marker-orange.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        })
    };
    
    // Create marker clusters
    const markerCluster = L.markerClusterGroup();
    
    // Add markers
    markers.forEach(function(marker) {
        if (marker.latitude && marker.longitude) {
            const icon = icons[marker.jenis_kerjasama] || icons['MOU'];
            
            const popupContent = `
                <div class="map-popup">
                    <h5>${marker.nama_mitra}</h5>
                    <p><strong>Jenis:</strong> ${marker.jenis_kerjasama}</p>
                    <p><strong>Periode:</strong> ${marker.tanggal_mulai} - ${marker.tanggal_akhir}</p>
                    <p><strong>Status:</strong> ${marker.status}</p>
                    <a href="${base_url}cooperation/data?id=${marker.id}" class="btn btn-sm btn-primary">Detail</a>
                </div>
            `;
            
            const mapMarker = L.marker([marker.latitude, marker.longitude], { icon: icon })
                .bindPopup(popupContent);
                
            markerCluster.addLayer(mapMarker);
        }
    });
    
    map.addLayer(markerCluster);
}
