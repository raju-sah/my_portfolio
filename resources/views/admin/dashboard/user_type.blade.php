<div id="chart" class="mt-4 w-50"></div>

@push('custom_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeData = @json($userType);

            // Initialize arrays for storing data
            const { newVisitors, returningVisitors, dates } = userTypeData.reduce((acc, item) => {
                if (item.newVsReturning === 'new') {
                    acc.newVisitors.push(item.activeUsers);
                } else if (item.newVsReturning === 'returning') {
                    acc.returningVisitors.push(item.activeUsers);
                }
                const date = new Date(item.date).getTime(); // Convert date to timestamp
                if (!acc.dates.includes(date)) {
                    acc.dates.push(date);
                }
                return acc;
            }, {
                newVisitors: [],
                returningVisitors: [],
                dates: []
            });


            var options = {
                series: [{
                    name: 'New Visitors',
                    data: newVisitors,
                }, {
                    name: 'Returning Visitors',
                    data: returningVisitors
                }],
                chart: {
                    type: 'area',
                    stacked: false,
                    height: 350,
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    toolbar: {
                        autoSelected: 'zoom'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0
                },
                title: {
                    text: 'User Types Over Time',
                    align: 'left'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90, 100]
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        }
                    },
                    title: {
                        text: 'Active Users'
                    }
                },
                xaxis: {
                    type: 'datetime',
                    categories: dates
                },
                tooltip: {
                    shared: false,
                    y: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
@endpush
