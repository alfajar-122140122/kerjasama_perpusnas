document.addEventListener('DOMContentLoaded', function() {
    // Line Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Kerjasama Baru',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
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