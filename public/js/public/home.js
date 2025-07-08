// Optimized vanilla JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Optimized chart options
    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    };

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [12, 19, 15, 25, 22, 30],
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0', '#FF5722'],
                borderWidth: 1
            }]
        },
        options: {
            ...defaultOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                data: [65, 78, 85, 95, 110, 125],
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            ...defaultOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Universitas', 'Pemerintah', 'Swasta', 'Internasional', 'Lainnya'],
            datasets: [{
                data: [40, 25, 15, 12, 8],
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0']
            }]
        },
        options: {
            ...defaultOptions,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { fontSize: 12, padding: 10 }
                }
            }
        }
    });
});