<div id="pieChart" class="w-50"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSources = @json($userSources);
        var options = {
            series: userSources.map((item) => item.activeUsers),
            chart: {
                width: '100%',
                type: 'pie',
            },
            labels: userSources.map((item) => item.firstUserSource),
            colors: ['#f39c12', '#00c0ef', '#00a65a', '#3c8dbc', '#e74c3c', '#3498db'],
            theme: {
                monochrome: {
                    enabled: false
                }
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        offset: -5
                    }
                }
            },
            title: {
                text: "User Source",
                align: 'left'
            },
            // dataLabels: {
            //     formatter(val, opts) {
            //         const name = opts.w.globals.labels[opts.seriesIndex]
            //         return [name, val.toFixed(1) + '%']
            //     }
            // },
            legend: {
                show: true
            }
        };

        var pieChart = new ApexCharts(document.querySelector('#pieChart'), options);
        pieChart.render();
    });
</script>
