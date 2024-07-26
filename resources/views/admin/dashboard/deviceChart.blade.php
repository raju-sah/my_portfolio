<div id="semiDonutChart" class="w-50"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const devices = @json($devices);
        var options = {
            series: devices.map((item) => item.activeUsers),
            labels: devices.map((item) => item.deviceCategory),
            colors: ['#34c38f', '#f46a6a', '#f7b84b', '#f1556c', '#556ee6'],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10
                }
            },
            grid: {
                padding: {
                    bottom: -80
                }
            },
            title: {
                text: 'Users By Device',
                align: 'left'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var semiDonutChart = new ApexCharts(document.querySelector("#semiDonutChart"), options);
        semiDonutChart.render();
    });
</script>
