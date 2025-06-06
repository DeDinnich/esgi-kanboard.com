import Chart from 'chart.js/auto';

const pastelColors = [
    '#A8DADC', '#F4A261', '#E9C46A', '#9D4EDD', '#90BE6D',
    '#F28482', '#A3C4F3', '#FBC4AB', '#BDB2FF', '#FFADAD'
];

export function renderBarChart(canvasId, labels, data, label) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label,
                data,
                backgroundColor: pastelColors.slice(0, labels.length),
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

export function renderPieChart(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor: pastelColors.slice(0, labels.length)
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#333',
                        padding: 16
                    }
                }
            }
        }
    });
}
