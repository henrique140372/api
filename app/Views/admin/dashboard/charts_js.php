<script>
    // tv_shows_completion_chart
    let tv_shows_completion_chart_options = {
        chart: {
            height: 280,
            type: "radialBar",
        },

        series: [<?= $anytc->series->completion_rate ?? 0 ?>],
        colors: ["#20E647"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "50%",
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#73879C",
                        fontSize: "13px"
                    },
                    value: {
                        color: "#73879C",
                        fontSize: "30px",
                        show: true
                    }
                }
            }
        },
        fill: {
            colors: ["#3498db"]
        },

        labels: ["TV Shows"]
    };
    let tv_shows_completion_chart = new ApexCharts(document.querySelector("#tv_shows_completion_chart"), tv_shows_completion_chart_options);
    tv_shows_completion_chart.render();

    //episodes_completion_chart
    let episodes_completion_chart_options = {
        chart: {
            height: 280,
            type: "radialBar",
        },

        series: [<?= $anytc->episodes->completion_rate ?? 0 ?>],
        colors: ["#3498db"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "50%",
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#73879C",
                        fontSize: "13px"
                    },
                    value: {
                        color: "#73879C",
                        fontSize: "30px",
                        show: true
                    }
                }
            }
        },
        fill: {
            colors: ["#3498db"]
        },

        labels: ["Episodes"]
    };
    let episodes_completion_chart = new ApexCharts(document.querySelector("#episodes_completion_chart"), episodes_completion_chart_options);
    episodes_completion_chart.render();

    //links_completion_chart
    let links_completion_chart_options = {
        chart: {
            height: 280,
            type: "radialBar",
        },

        series: [
            <?= $anytc->links_completion->download->completion_rate ?? 0 ?>,
            <?= $anytc->links_completion->stream->completion_rate ?? 0 ?>
        ],
        colors: ["#26b99a"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "50%",
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#73879C",
                        fontSize: "13px"
                    },
                    value: {
                        color: "#73879C",
                        fontSize: "30px",
                        show: true
                    }
                }
            }
        },
        fill: {
            colors: ["#26b99a", "#3498db"]
        },

        labels: ["Download", "Stream"]
    };
    let links_completion_chart = new ApexCharts(document.querySelector("#links_completion_chart"), links_completion_chart_options);
    links_completion_chart.render();

</script>