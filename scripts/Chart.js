document.addEventListener("DOMContentLoaded", function () {
    if (typeof Chart === "undefined") {
        return;
    }

    const chartColors = [
        '#8E9CE6',
        '#CDD3F4',
        '#AFC4F5',
        '#B9D8F2',
        '#C7BDEB',
        '#D8C7EE',
        '#E5E9FA'
    ];

    const transparentColors = [
        'rgba(142, 156, 230, 0.35)',
        'rgba(205, 211, 244, 0.45)',
        'rgba(175, 196, 245, 0.45)',
        'rgba(185, 216, 242, 0.45)',
        'rgba(199, 189, 235, 0.45)',
        'rgba(216, 199, 238, 0.45)',
        'rgba(229, 233, 250, 0.55)'
    ];

    const makeChart = function (canvasID, type, chartData, label) {
        const ctx = document.getElementById(canvasID);

        if (!ctx || !chartData) {
            return;
        }

        new Chart(ctx, {
            type: type,
            data: {
                labels: chartData.label,
                datasets: [{
                    label: label,
                    data: chartData.data,
                    backgroundColor: type === 'bar' ? transparentColors : chartColors,
                    borderColor: chartColors,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: type === 'bar' ? 'top' : 'bottom'
                    }
                },
                scales: type === 'bar' ? {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                } : {}
            }
        });
    };

    makeChart("adminChart1", 'bar', window.barData, "Status of Pets");
    makeChart("adminChart2", 'pie', window.barData2, "Status of Roles");
    makeChart("adminChart3", 'doughnut', window.barData3, "Pets by Species");
    makeChart("adminChart4", 'bar', window.barData4, "Pets by Age");
    makeChart("adminChart5", 'bar', window.barData5, "Users by Age Group");
    makeChart("adminChart6", 'doughnut', window.barData6, "Users by Privilege");
});