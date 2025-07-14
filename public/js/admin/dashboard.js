document.addEventListener('DOMContentLoaded', function() {
    // Prepare statistik bulanan data from global variable
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

    // Bar Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
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

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Selesai', 'Pending'],
            datasets: [{
                data: [15, 8, 2],
                backgroundColor: [
                    'rgb(13, 110, 253)',
                    'rgb(25, 135, 84)',
                    'rgb(255, 193, 7)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Animate numbers
    function animateNumbers() {
        const numbers = document.querySelectorAll('.stats-number');
        numbers.forEach(number => {
            const target = parseInt(number.textContent);
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                number.textContent = Math.floor(current);
            }, 30);
        });
    }

    // Start animations
    setTimeout(animateNumbers, 500);
});