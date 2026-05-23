// Initialize Lucide icons
lucide.createIcons();

// Simple scroll effect for header
window.addEventListener('scroll', () => {
    const header = document.querySelector('.main-header');
    if (header) {
        if (window.scrollY > 50) {
            header.style.padding = '10px 0';
            header.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
        } else {
            header.style.padding = '0';
            header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
        }
    }
});

// Dashboard Charts Initialization
function initDashboardCharts() {
    const barChartCtx = document.getElementById('barChart');
    if (barChartCtx) {
        new Chart(barChartCtx, {
            type: 'bar',
            data: {
                labels: ['Mars', 'Mars', 'Mars', 'Abril', 'May', 'Junio'],
                datasets: [
                    {
                        label: 'Cumpleaños',
                        data: [85, 75, 100, 95, 68, 110],
                        backgroundColor: '#26ba9d',
                        borderRadius: 5
                    },
                    {
                        label: 'Matrimonios',
                        data: [42, 65, 55, 48, 88, 72],
                        backgroundColor: '#ff8a65',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    const donutChartCtx = document.getElementById('donutChart');
    if (donutChartCtx) {
        new Chart(donutChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cumpleaños', 'Solo Fiestas', 'Bautizos', 'Matrimonios', 'Others'],
                datasets: [{
                    data: [42, 22, 17, 13, 6],
                    backgroundColor: ['#26ba9d', '#ff8a65', '#3498db', '#800040', '#95a5a6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                },
                cutout: '70%'
            }
        });
    }

    const gaugeChartCtx = document.getElementById('gaugeChart');
    if (gaugeChartCtx) {
        new Chart(gaugeChartCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [88, 12],
                    backgroundColor: ['#26ba9d', '#f0f0f0'],
                    circumference: 180,
                    rotation: 270,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: { enabled: false },
                    legend: { display: false }
                },
                cutout: '80%'
            }
        });
    }
}

// Call init on load
window.addEventListener('load', () => {
    initDashboardCharts();
    initDropdowns();
});

// Dropdown Menus Initialization
function initDropdowns() {
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('.menu-trigger');
        const dropdowns = document.querySelectorAll('.card-dropdown');
        
        // Close all dropdowns if clicking outside
        if (!trigger) {
            dropdowns.forEach(d => d.style.display = 'none');
            return;
        }

        const dropdown = trigger.nextElementSibling;
        if (dropdown) {
            const isVisible = dropdown.style.display === 'block';
            dropdowns.forEach(d => d.style.display = 'none');
            dropdown.style.display = isVisible ? 'none' : 'block';
        }
    });
}

// Gallery play overlay hover
const playOverlay = document.querySelector('.play-overlay');
if (playOverlay) {
    playOverlay.addEventListener('mouseenter', () => {
        playOverlay.style.transform = 'translate(-50%, -50%) scale(1.1)';
        playOverlay.style.background = 'white';
    });
    playOverlay.addEventListener('mouseleave', () => {
        playOverlay.style.transform = 'translate(-50%, -50%) scale(1)';
        playOverlay.style.background = 'rgba(255,255,255,0.9)';
    });
}
