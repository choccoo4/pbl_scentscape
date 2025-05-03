import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Penjualan',
                data: [5, 8, 6, 10, 4, 7, 12],
                borderColor: '#9BAF9A',
                backgroundColor: 'rgba(155, 175, 154, 0.2)',
                tension: 0.4,
                pointBackgroundColor: '#9BAF9A',
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 2
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
