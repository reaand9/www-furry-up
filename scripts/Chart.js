document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // CHART 1 - PET STATUS
    // =========================
    const ctx1 = document.getElementById("adminChart1");

    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: window.barData.label,
                datasets: [{
                    label: "Status of Pets",
                    data: window.barData.data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // =========================
    // CHART 2 - USER ROLES
    // =========================
    const ctx2 = document.getElementById("adminChart2");

    if (ctx2) {
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: window.barData2.label,
                datasets: [{
                    label: "Status of Roles",
                    data: window.barData2.data,
                    backgroundColor: [
                        '#ff6384',
                        '#ff9f40',
                        '#ffcd56',
                        '#4bc0c0',
                        '#36a2eb',
                        '#9966ff',
                        '#c9cbcf'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

});document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // CHART 1 - PET STATUS
    // =========================
    const ctx1 = document.getElementById("adminChart1");

    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: window.barData.label,
                datasets: [{
                    label: "Status of Pets",
                    data: window.barData.data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // =========================
    // CHART 2 - USER ROLES
    // =========================
    const ctx2 = document.getElementById("adminChart2");

    if (ctx2) {
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: window.barData2.label,
                datasets: [{
                    label: "Status of Roles",
                    data: window.barData2.data,
                    backgroundColor: [
                        '#ff6384',
                        '#ff9f40',
                        '#ffcd56',
                        '#4bc0c0',
                        '#36a2eb',
                        '#9966ff',
                        '#c9cbcf'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

});