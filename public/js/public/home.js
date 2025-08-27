// Data from controller - will be updated from window.statistikData if available
let jenisLembagaData = {};
let originalJenisLembagaData = {};
let yearlyData = {};
let monthlyData2025 = {};

// Data yang bisa difilter berdasarkan kriteria mitra (static fallback)
let jenisIdentitasMitraData = {
    'PTS': {
        'Universitas': 350,
        'Institut': 120,
        'Sekolah Tinggi': 59
    },
    'PTN': {
        'Universitas': 18,
        'Institut': 4,
        'Politeknik': 2
    },
    'Swasta': {
        'Perusahaan': 8,
        'Yayasan': 3,
        'Koperasi': 1
    },
    'Pemerintah': {
        'K/L': 25,
        'Pemda': 10,
        'BUMN': 3
    },
    'LuarNegeri': {
        'Universitas': 4,
        'Organisasi': 2
    }
};

// Slider functionality
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.hero-slide');
const indicators = document.querySelectorAll('.hero-indicator');
let slideInterval;

// Chart instances
let pieChart, yearlyChart, monthlyChart;

// Initialize data from PHP if available
document.addEventListener('DOMContentLoaded', function() {
    if (window.statistikData) {
        // Update with real data from PHP
        jenisLembagaData = window.statistikData.jenis_mitra || {
            'PTS': 0, 'K/L': 0, 'PTN': 0, 'Swasta': 0, 'Luar Negeri': 0
        };
        originalJenisLembagaData = {...jenisLembagaData};
        yearlyData = window.statistikData.tren_tahun || window.statistikData.per_tahun || {};
        monthlyData2025 = window.statistikData.tren_bulanan || window.statistikData.per_bulan || {};
    } else {
        // Fallback to static data
        jenisLembagaData = {
            'PTS': 529, 'K/L': 38, 'PTN': 24, 'Swasta': 12, 'Luar Negeri': 6
        };
        originalJenisLembagaData = {...jenisLembagaData};
        yearlyData = {
            '2019': 0, '2020': 0, '2021': 0, '2022': 0, '2023': 0, '2024': 0, '2025': 0
        };
        monthlyData2025 = {
            'January': 2, 'February': 1, 'March': 45, 'April': 0, 'May': 1, 'June': 0,
            'July': 0, 'August': 0, 'September': 9, 'October': 105, 'November': 60, 'December': 44
        };
    }
    
    initializeSlider();
    initializeCharts();
    updateAllLegends();
});

function initializeSlider() {
    // Show first slide
    if (slides.length > 0) {
        showSlide(0);
        startAutoSlide();
    }
}

function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => slide.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));
    
    // Show current slide
    if (slides[index]) {
        slides[index].classList.add('active');
    }
    if (indicators[index]) {
        indicators[index].classList.add('active');
    }
    
    currentSlideIndex = index;
}

function changeSlide(direction) {
    stopAutoSlide();
    
    let newIndex = currentSlideIndex + direction;
    
    if (newIndex >= slides.length) {
        newIndex = 0;
    } else if (newIndex < 0) {
        newIndex = slides.length - 1;
    }
    
    showSlide(newIndex);
    startAutoSlide();
}

function currentSlide(index) {
    stopAutoSlide();
    showSlide(index - 1);
    startAutoSlide();
}

function nextSlide() {
    changeSlide(1);
}

function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
}

function stopAutoSlide() {
    if (slideInterval) {
        clearInterval(slideInterval);
    }
}

// Pause auto-slide when user hovers over slider
const sliderContainer = document.querySelector('.hero-slider-container');
if (sliderContainer) {
    sliderContainer.addEventListener('mouseenter', stopAutoSlide);
    sliderContainer.addEventListener('mouseleave', startAutoSlide);
}

// Touch/swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

if (sliderContainer) {
    sliderContainer.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    sliderContainer.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next slide
            changeSlide(1);
        } else {
            // Swipe right - previous slide
            changeSlide(-1);
        }
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        changeSlide(-1);
    } else if (e.key === 'ArrowRight') {
        changeSlide(1);
    }
});

function initializeCharts() {
    // Pie Chart for Jenis Lembaga
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(jenisLembagaData),
            datasets: [{
                data: Object.values(jenisLembagaData),
                backgroundColor: [
                    '#8e44ad', // PTS - Purple
                    '#3498db', // K/L - Blue  
                    '#2ecc71', // PTN - Green
                    '#f39c12', // Swasta - Orange
                    '#e74c3c'  // Luar Negeri - Red
                ],
                borderWidth: 2,
                borderColor: '#fff',
                hoverBorderWidth: 4,
                hoverBorderColor: '#333'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Gunakan legend custom
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed * 100) / total).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#ddd',
                    borderWidth: 1
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1000
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Bar Chart for Yearly Data - menggunakan data real
    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    
    // Convert array of objects to simple arrays for Chart.js
    let yearlyLabels = [];
    let yearlyValues = [];
    
    if (Array.isArray(yearlyData)) {
        // If yearlyData is array of objects from database
        yearlyLabels = yearlyData.map(item => item.tahun);
        yearlyValues = yearlyData.map(item => parseInt(item.jumlah));
    } else {
        // If yearlyData is plain object
        yearlyLabels = Object.keys(yearlyData);
        yearlyValues = Object.values(yearlyData).map(val => parseInt(val));
    }
    
    yearlyChart = new Chart(yearlyCtx, {
        type: 'bar',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: 'Jumlah Kerjasama',
                data: yearlyValues,
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 300,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    });

    // Bar Chart for Monthly Data (2025)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const monthlyValues = monthlyLabels.map(month => monthlyData2025[month] || 0);
    
    monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Jumlah MOU',
                data: monthlyValues,
                backgroundColor: [
                    '#ffeb3b', '#e91e63', '#f39c12', '#e74c3c', // Jan-Apr
                    '#f39c12', '#9c27b0', '#f39c12', '#2196f3', // May-Aug  
                    '#9c27b0', '#4caf50', '#e91e63', '#4caf50'  // Sep-Dec
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 120,
                    ticks: {
                        stepSize: 20
                    }
                }
            }
        }
    });
}

function updateAllLegends() {
    // Update Pie Chart Legend (Jenis Lembaga)
    document.getElementById('pieChart_ptsCount').textContent = jenisLembagaData['PTS'];
    document.getElementById('pieChart_klCount').textContent = jenisLembagaData['K/L'];
    document.getElementById('pieChart_ptnCount').textContent = jenisLembagaData['PTN'];
    document.getElementById('pieChart_swastaCount').textContent = jenisLembagaData['Swasta'];
    document.getElementById('pieChart_luarNegeriCount').textContent = jenisLembagaData['Luar Negeri'];
    
    const totalJenisLembaga = Object.values(jenisLembagaData).reduce((a, b) => a + b, 0);
    document.getElementById('pieChart_totalLembaga').textContent = totalJenisLembaga;
    
    // Update Yearly Chart Legend - handle both array and object format
    if (Array.isArray(yearlyData)) {
        // If yearlyData is array of objects from database
        yearlyData.forEach(item => {
            const element = document.getElementById(`year_${item.tahun}`);
            if (element) {
                element.textContent = item.jumlah;
            }
        });
    } else {
        // If yearlyData is plain object
        Object.keys(yearlyData).forEach(year => {
            const element = document.getElementById(`year_${year}`);
            if (element) {
                element.textContent = yearlyData[year];
            }
        });
    }
    
    // Update Monthly Chart Legend (hanya bulan yang ada data)
    const monthsWithData = ['january', 'february', 'march', 'may', 'september', 'october', 'november', 'december'];
    monthsWithData.forEach(month => {
        const monthCapitalized = month.charAt(0).toUpperCase() + month.slice(1);
        const element = document.getElementById(`month_${month}`);
        if (element) {
            element.textContent = monthlyData2025[monthCapitalized] || 0;
        }
    });
    
    // Update monthly total
    const monthlyTotal = Object.values(monthlyData2025).reduce((a, b) => a + b, 0);
    document.getElementById('monthly_total').textContent = monthlyTotal;
}

// Fungsi khusus untuk update pie chart berdasarkan filter mitra
function updatePieChart() {
    const mitraFilter = document.getElementById('mitraFilter').value;
    const yearFilter = document.getElementById('yearFilter').value;
    const jenisFilter = document.getElementById('jenisFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    // Show loading state
    document.getElementById('pieChart').closest('.chart-container').classList.add('chart-loading');
    
    // Update filter info
    let filterText = 'Menampilkan: ';
    if (mitraFilter) {
        filterText += `${mitraFilter} `;
    } else {
        filterText += 'Semua Jenis Identitas Mitra ';
    }
    
    if (yearFilter) filterText += `(${yearFilter}) `;
    if (jenisFilter) filterText += `[${jenisFilter}] `;
    if (statusFilter) filterText += `{${statusFilter}} `;
    
    document.getElementById('pieChartFilterInfo').textContent = filterText;
    
    // Build query parameters
    const params = new URLSearchParams();
    if (mitraFilter) params.append('mitra', mitraFilter);
    if (yearFilter) params.append('year', yearFilter);
    if (jenisFilter) params.append('jenis', jenisFilter);
    if (statusFilter) params.append('status', statusFilter);
    
    // Check if we have a base URL function available
    const baseUrl = window.baseUrl || '';
    
    // Make AJAX call to get filtered pie chart data
    fetch(`${baseUrl}/api/mitra-statistics?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            // Update pie chart data
            if (data.jenisIdentitasMitra) {
                pieChart.data.labels = Object.keys(data.jenisIdentitasMitra);
                pieChart.data.datasets[0].data = Object.values(data.jenisIdentitasMitra);
                
                // Update colors based on filtered data
                const colors = generateColorsForLabels(Object.keys(data.jenisIdentitasMitra));
                pieChart.data.datasets[0].backgroundColor = colors;
                
                pieChart.update('active');
                jenisLembagaData = data.jenisIdentitasMitra;
            }
            
            // Update pie chart legend
            updatePieChartLegend();
            
            // Remove loading state
            document.getElementById('pieChart').closest('.chart-container').classList.remove('chart-loading');
        })
        .catch(error => {
            console.error('Error fetching filtered mitra statistics:', error);
            
            // Fallback to original data if error
            pieChart.data.labels = Object.keys(originalJenisLembagaData);
            pieChart.data.datasets[0].data = Object.values(originalJenisLembagaData);
            pieChart.data.datasets[0].backgroundColor = [
                '#8e44ad', '#3498db', '#2ecc71', '#f39c12', '#e74c3c'
            ];
            pieChart.update();
            jenisLembagaData = {...originalJenisLembagaData};
            updatePieChartLegend();
            
            // Remove loading state
            document.getElementById('pieChart').closest('.chart-container').classList.remove('chart-loading');
        });
}

// Generate colors for dynamic labels
function generateColorsForLabels(labels) {
    const colorPalette = [
        '#8e44ad', '#3498db', '#2ecc71', '#f39c12', '#e74c3c',
        '#9b59b6', '#34495e', '#16a085', '#f39c12', '#c0392b',
        '#d35400', '#7f8c8d', '#27ae60', '#2980b9', '#8e44ad'
    ];
    
    return labels.map((label, index) => {
        // Map specific labels to specific colors
        switch(label) {
            case 'PTS': return '#8e44ad';
            case 'K/L': return '#3498db';
            case 'PTN': return '#2ecc71';
            case 'Swasta': return '#f39c12';
            case 'Luar Negeri': return '#e74c3c';
            default: return colorPalette[index % colorPalette.length];
        }
    });
}

// Update only pie chart legend
function updatePieChartLegend() {
    // Clear existing legend items
    const legendContainer = document.querySelector('#pieChart').closest('.card-body').querySelector('.chart-legend');
    
    // Update with current data
    Object.keys(jenisLembagaData).forEach(key => {
        const element = document.getElementById(`pieChart_${key.toLowerCase().replace(/[^a-z0-9]/g, '')}Count`);
        if (element) {
            element.textContent = jenisLembagaData[key];
        }
    });
    
    // Update total
    const total = Object.values(jenisLembagaData).reduce((a, b) => a + b, 0);
    document.getElementById('pieChart_totalLembaga').textContent = total;
}

// Enhanced updateStatistics function
function updateStatistics() {
    const yearFilter = document.getElementById('yearFilter').value;
    const jenisFilter = document.getElementById('jenisFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    // Update monthly chart title
    const title = yearFilter ? `Tahun ${yearFilter}` : 'Tahun 2025';
    document.getElementById('monthlyChartTitle').textContent = title;
    
    // Build query parameters
    const params = new URLSearchParams();
    if (yearFilter) params.append('year', yearFilter);
    if (jenisFilter) params.append('jenis', jenisFilter);
    if (statusFilter) params.append('status', statusFilter);
    
    // Check if we have a base URL function available
    const baseUrl = window.baseUrl || '';
    
    // Make AJAX call to get filtered statistics
    fetch(`${baseUrl}/api/statistics?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            // Update charts and legends with new data
            if (data.jenisLembaga) {
                pieChart.data.datasets[0].data = Object.values(data.jenisLembaga);
                pieChart.update();
                jenisLembagaData = data.jenisLembaga;
            }
            
            if (data.yearlyData) {
                yearlyChart.data.labels = Object.keys(data.yearlyData);
                yearlyChart.data.datasets[0].data = Object.values(data.yearlyData);
                yearlyChart.update();
                yearlyData = data.yearlyData;
            }
            
            if (data.monthlyData) {
                const monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const monthlyValues = monthlyLabels.map(month => data.monthlyData[month] || 0);
                monthlyChart.data.datasets[0].data = monthlyValues;
                monthlyChart.update();
                monthlyData2025 = data.monthlyData;
            }
            
            // Update all legends
            updateAllLegends();
            
            // Also update pie chart with current mitra filter
            updatePieChart();
        })
        .catch(error => {
            console.error('Error fetching filtered statistics:', error);
            // Fallback logic...
        });
    console.log('Statistics will be updated here');

}

function resetFilters() {
    document.getElementById('yearFilter').value = '';
    document.getElementById('jenisFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('mitraFilter').value = '';
    
    // Reset pie chart filter info
    document.getElementById('pieChartFilterInfo').textContent = 'Menampilkan: Semua Jenis Identitas Mitra';
    
    updateStatistics();
}

// Function to update monthly chart based on selected year
function updateMonthlyChart() {
    const selectedYear = document.getElementById('yearFilter').value;
    
    // Update chart title
    document.getElementById('monthlyChartTitle').textContent = `Bulanan ${selectedYear}`;
    
    // Fetch data for selected year via AJAX
    fetch(`${window.location.origin}/ajax/monthly-data/${selectedYear}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update monthlyData2025 with new data
                const monthlyData = data.monthlyData || {};
                
                // Update chart
                if (monthlyChart) {
                    const monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    const monthlyValues = monthlyLabels.map(month => monthlyData[month] || 0);
                    
                    monthlyChart.data.datasets[0].data = monthlyValues;
                    monthlyChart.update();
                }
                
                // Update legend
                const monthNames = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
                monthNames.forEach(month => {
                    const monthCapitalized = month.charAt(0).toUpperCase() + month.slice(1);
                    const element = document.getElementById(`month_${month}`);
                    if (element) {
                        element.textContent = monthlyData[monthCapitalized] || 0;
                    }
                });
                
                // Update total
                const total = Object.values(monthlyData).reduce((a, b) => a + b, 0);
                document.getElementById('monthly_total').textContent = total;
            }
        })
        .catch(error => {
            console.log('Using fallback data for year:', selectedYear);
            // Fallback: update with empty data for now
            updateMonthlyChartFallback(selectedYear);
        });
}

// Fallback function when AJAX fails
function updateMonthlyChartFallback(year) {
    // Update chart title
    document.getElementById('monthlyChartTitle').textContent = `Bulanan ${year}`;
    
    // Set all months to 0 for years without data
    const emptyData = {};
    const monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
    monthLabels.forEach(month => {
        emptyData[month] = 0;
    });
    
    // Update chart
    if (monthlyChart) {
        const monthlyValues = monthLabels.map(month => emptyData[month] || 0);
        monthlyChart.data.datasets[0].data = monthlyValues;
        monthlyChart.update();
    }
    
    // Update legend
    const monthNames = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
    monthNames.forEach(month => {
        const element = document.getElementById(`month_${month}`);
        if (element) {
            element.textContent = 0;
        }
    });
    
    // Update total
    document.getElementById('monthly_total').textContent = 0;
}

// Export functions for global access
window.changeSlide = changeSlide;
window.currentSlide = currentSlide;
window.updateStatistics = updateStatistics;
window.updatePieChart = updatePieChart;
window.updateMonthlyChart = updateMonthlyChart;
window.resetFilters = resetFilters;