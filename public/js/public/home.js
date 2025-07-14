// Optimized vanilla JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart Statistik Kerjasama Bulanan
    let labels = [];
    let data = [];
    if (typeof statistikBulanan !== 'undefined' && Array.isArray(statistikBulanan)) {
        labels = statistikBulanan.map(item => {
            // Format bulan: 2024-01 -> Jan 2024
            const [year, month] = item.bulan.split('-');
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return monthNames[parseInt(month, 10) - 1] + ' ' + year;
        });
        data = statistikBulanan.map(item => item.total);
    }

    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels.length ? labels : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Kerjasama Baru',
                data: data.length ? data : [0,0,0,0,0,0,0,0,0,0,0,0],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Line Chart Pertumbuhan Kerjasama Tahunan
    let yearLabels = [];
    let yearData = [];
    if (typeof statistikTahunan !== 'undefined' && Array.isArray(statistikTahunan)) {
        yearLabels = statistikTahunan.map(item => item.tahun);
        yearData = statistikTahunan.map(item => item.total);
    }
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: yearLabels.length ? yearLabels : ['2019', '2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Total Kerjasama',
                data: yearData.length ? yearData : [0,0,0,0,0,0],
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Pie Chart Distribusi Tipe Mitra
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Universitas', 'Pemerintah', 'Swasta', 'Internasional', 'Lainnya'],
            datasets: [{
                data: typeof distribusiMitra !== 'undefined' && distribusiMitra.length ? distribusiMitra : [0,0,0,0,0],
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { fontSize: 12, padding: 10 }
                }
            }
        }
    });
});