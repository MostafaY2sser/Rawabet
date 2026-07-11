// Chart instance
let projectChart = null;

// Data sets matching the exact pattern from the image
const chartData = {
    monthly: {
        labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
        // Blue line data - matches the pattern in the image
        primary: [5, 12, 8, 15, 10, 18, 12, 20, 15, 25, 45, 50],
        // Orange line data - matches the pattern in the image  
        secondary: [2, 8, 5, 12, 18, 25, 35, 40, 30, 35, 25, 45]
    },
    weekly: {
        labels: ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4'],
        primary: [15, 35, 25, 50],
        secondary: [10, 30, 20, 45]
    },
    daily: {
        labels: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
        primary: [20, 15, 30, 25, 40, 35, 50],
        secondary: [15, 25, 20, 35, 30, 45, 40]
    }
};

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeChart();
    setupTabNavigation();
    setupAnimations();
});

// Initialize Chart.js to match the exact image pattern
function initializeChart() {
    const ctx = document.getElementById('projectChart').getContext('2d');
    
    const config = {
        type: 'line',
        data: {
            labels: chartData.monthly.labels,
            datasets: [
                {
                    label: 'المقاييس الأساسية',
                    data: chartData.monthly.primary,
                    borderColor: '#4F46E5',
                    backgroundColor: 'transparent',
                    borderWidth: 2.5,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#4F46E5',
                    pointBorderColor: '#4F46E5',
                    pointBorderWidth: 0,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#4F46E5',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                },
                {
                    label: 'المقاييس الثانوية',
                    data: chartData.monthly.secondary,
                    borderColor: '#F97316',
                    backgroundColor: 'transparent',
                    borderWidth: 2.5,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#F97316',
                    pointBorderColor: '#F97316',
                    pointBorderWidth: 0,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#F97316',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    usePointStyle: true,
                    padding: 10,
                    titleFont: {
                        size: 13,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 12,
                        weight: '500'
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: true,
                        color: '#f1f5f9',
                        lineWidth: 1,
                        drawTicks: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11,
                            weight: '400'
                        },
                        padding: 8,
                        maxRotation: 0
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: '#f8fafc',
                        lineWidth: 1,
                        drawTicks: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11,
                            weight: '400'
                        },
                        padding: 12,
                        stepSize: 25,
                        callback: function(value) {
                            return value;
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            hover: {
                animationDuration: 200
            },
            elements: {
                line: {
                    capBezierPoints: false
                }
            }
        }
    };
    
    projectChart = new Chart(ctx, config);
}

// Setup tab navigation
function setupTabNavigation() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const currentValue = document.querySelector('.current-value');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all tabs
            tabButtons.forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Get the selected period
            const period = this.dataset.period;
            
            // Update chart data with animation
            updateChartData(period);
            
            // Update current value with animation
            updateCurrentValue(period, currentValue);
            
            // Add slide animation to the button
            this.classList.add('slide-in');
            setTimeout(() => {
                this.classList.remove('slide-in');
            }, 400);
        });
    });
}

// Update chart data
function updateChartData(period) {
    if (!projectChart || !chartData[period]) return;
    
    const data = chartData[period];
    
    // Update chart data
    projectChart.data.labels = data.labels;
    projectChart.data.datasets[0].data = data.primary;
    projectChart.data.datasets[1].data = data.secondary;
    
    // Update chart with animation
    projectChart.update('active');
}

// Update current value with animation
function updateCurrentValue(period, element) {
    const data = chartData[period];
    const maxValue = Math.max(...data.primary, ...data.secondary);
    
    // Animate number change
    animateNumber(element, parseInt(element.textContent), maxValue, 600);
}

// Animate number changes
function animateNumber(element, start, end, duration) {
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;
    
    const timer = setInterval(function() {
        current += increment;
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }
        element.textContent = Math.round(current);
    }, 16);
}

// Setup page animations
function setupAnimations() {
    // Add fade-in animation to dashboard card
    const dashboardCard = document.querySelector('.dashboard-card');
    dashboardCard.classList.add('fade-in');
    
    // Add staggered animations to elements
    const elements = [
        '.header',
        '.tabs-container',
        '.chart-container',
        // '.chart-legend'
    ];
    
    elements.forEach((selector, index) => {
        const element = document.querySelector(selector);
        if (element) {
            setTimeout(() => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100);
            }, index * 150);
        }
    });
}

// Add smooth hover effects
document.addEventListener('mouseover', function(e) {
    if (e.target.classList.contains('tab-button') && !e.target.classList.contains('active')) {
        e.target.style.transform = 'translateY(-2px)';
    }
});

document.addEventListener('mouseout', function(e) {
    if (e.target.classList.contains('tab-button') && !e.target.classList.contains('active')) {
        e.target.style.transform = 'translateY(0)';
    }
});

// Handle responsive behavior
window.addEventListener('resize', function() {
    if (projectChart) {
        projectChart.resize();
    }
});