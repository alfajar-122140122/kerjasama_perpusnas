// Data from controller - sesuai dengan tabel dari gambar
let jenisLembagaData = {
    'PTS': 529,
    'K/L': 38,
    'PTN': 24,
    'Swasta': 12,
    'Luar Negeri': 6
};

let yearlyData = {
    '2013': 5, '2014': 4, '2015': 14, '2016': 47, '2017': 65,
    '2018': 76, '2019': 267, '2020': 25, '2021': 121
};

let monthlyData2022 = {
    'January': 2, 'February': 1, 'March': 45, 'April': 0, 'May': 1, 'June': 0,
    'July': 0, 'August': 0, 'September': 9, 'October': 105, 'November': 60, 'December': 44
};

// Chart instances
let pieChart, yearlyChart, monthlyChart;

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    updateAllLegends();
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
                borderColor: '#fff'
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
                    }
                }
            }
        }
    });

    // Bar Chart for Yearly Data
    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    yearlyChart = new Chart(yearlyCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(yearlyData),
            datasets: [{
                label: 'Jumlah MOU',
                data: Object.values(yearlyData),
                backgroundColor: '#f39c12',
                borderColor: '#d68910',
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

    // Bar Chart for Monthly Data (2022)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const monthlyValues = monthlyLabels.map(month => monthlyData2022[month] || 0);
    
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
    
    // Update Yearly Chart Legend
    Object.keys(yearlyData).forEach(year => {
        const element = document.getElementById(`year_${year}`);
        if (element) {
            element.textContent = yearlyData[year];
        }
    });
    
    // Update Monthly Chart Legend (hanya bulan yang ada data)
    const monthsWithData = ['january', 'february', 'march', 'may', 'september', 'october', 'november', 'december'];
    monthsWithData.forEach(month => {
        const monthCapitalized = month.charAt(0).toUpperCase() + month.slice(1);
        const element = document.getElementById(`month_${month}`);
        if (element) {
            element.textContent = monthlyData2022[monthCapitalized] || 0;
        }
    });
    
    // Update monthly total
    const monthlyTotal = Object.values(monthlyData2022).reduce((a, b) => a + b, 0);
    document.getElementById('monthly_total').textContent = monthlyTotal;
}

function updateStatistics() {
    const yearFilter = document.getElementById('yearFilter').value;
    
    // Update monthly chart title
    const title = yearFilter ? `Tahun ${yearFilter}` : 'Tahun 2022';
    document.getElementById('monthlyChartTitle').textContent = title;
    
    // Build query parameters
    const params = new URLSearchParams();
    if (yearFilter) params.append('year', yearFilter);
    
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
                monthlyData2022 = data.monthlyData;
            }
            
            // Update all legends
            updateAllLegends();
        })
        .catch(error => {
            console.error('Error fetching filtered statistics:', error);
            // Fallback to original data if error
            pieChart.data.datasets[0].data = Object.values(jenisLembagaData);
            pieChart.update();
            
            yearlyChart.data.labels = Object.keys(yearlyData);
            yearlyChart.data.datasets[0].data = Object.values(yearlyData);
            yearlyChart.update();
            
            const monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const monthlyValues = monthlyLabels.map(month => monthlyData2022[month] || 0);
            monthlyChart.data.datasets[0].data = monthlyValues;
            monthlyChart.update();
        });
}

function resetFilters() {
    document.getElementById('yearFilter').value = '';
    updateStatistics();
}

// Export functions for global access
window.updateStatistics = updateStatistics;
window.resetFilters = resetFilters;