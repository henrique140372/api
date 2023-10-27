

let EarningsByMonthly_LineChart = new ApexCharts(document.getElementById('line-chart-earnings-by-monthly'), {

    series: [],
    chart: {
        colors: ['#ffcf00'],
        foreColor: '#ffffff99',
        height: 350,
        type: 'line',
        zoom: {
            enabled: false
        },
        animations: {
            enabled: false
        },
        toolbar: {
            show: false
        }
    },
    dataLabels: {
        enabled: false
    },

    stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: undefined,
        width: 3,
        dashArray: 0,
    },
    grid: {
        borderColor: '#47494d',
        row: {
            opacity: 0.5
        }
    },
    markers: {
        size: [4, 7]
    },
    animations: {
        enabled: true,
        easing: 'linear',
        dynamicAnimation: {
            speed: 1000
        }
    },
    xaxis: {
        lines: {
            show: true
        },
        tickPlacement: 'on',
        type: 'datetime',
        labels: {
            show: true,
            format: 'dd MMM'
        }
    },
    tooltip: {
        enabled: true,
        custom: undefined,
        fillSeriesColor: false,
        theme: 'dark',
    },
    noData: {
        text: 'Loading...'
    },
    legend: {
        show: true,
    }
});
document.addEventListener("DOMContentLoaded", function () {
    window.ApexCharts && EarningsByMonthly_LineChart.render();
});

let ReferralsByMonthly_LineChart = new ApexCharts(document.getElementById('line-chart-referrals-by-monthly'), {

    series: [],
    chart: {
        colors: ['#ffcf00'],
        foreColor: '#ffffff99',
        height: 350,
        type: 'area',
        zoom: {
            enabled: false
        },
        animations: {
            enabled: false
        },
        toolbar: {
            show: false
        }
    },
    colors: ["#206bc4","#f66d9b"],
    dataLabels: {
        enabled: false
    },
    fill: {
        opacity: .16,
        type: 'solid'
    },
    stroke: {
        show: true,
        width: 2,
        lineCap: "round",
        curve: "smooth",
    },
    grid: {
        padding: {

            bottom: 15
        },
        borderColor: '#47494d',
        strokeDashArray: 4,
        xaxis: {
            lines: {
                show: true
            }
        },
    },
    animations: {
        enabled: true,
        easing: 'linear',
        dynamicAnimation: {
            speed: 1000
        }
    },
    xaxis: {
        lines: {
            show: true
        },
        type: 'datetime',
        labels: {
            show: true,
            format: 'dd MMM'
        },
    },
    tooltip: {
        enabled: true,
        custom: undefined,
        fillSeriesColor: false,
        theme: 'dark',
    },
    noData: {
        text: 'Loading...'
    },
    legend: {
        show: true,
    }
});
document.addEventListener("DOMContentLoaded", function () {
    window.ApexCharts && ReferralsByMonthly_LineChart.render();
});

