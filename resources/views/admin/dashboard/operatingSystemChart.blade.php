<div id="donutChart" class="w-50"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const operatingSystems = @json($operatingSystems);
        //converting object to array
        const operatingSystemsArray = Object.values(operatingSystems);
        var options = {
            series: operatingSystemsArray.map((item) => item.activeUsers),
            chart: {
                type: 'donut',
            },
            labels: operatingSystemsArray.map((item) => item.operatingSystem),
            title: {
                text: 'Users By Operating System',
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
        var donutChart = new ApexCharts(document.querySelector("#donutChart"), options);
        donutChart.render();
    });
</script>
