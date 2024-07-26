<div class="container">
    <div class="row bg-white">

        <div class="col-md-3">
            <div class="filter-card active-line dropdown">
                <button class="btn dropdown-toggle mt-2" id="firstType" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" data-value="{{ \App\Enums\FirstAnalyticsType::cases()[0]->name }}">
                    {{ \App\Enums\FirstAnalyticsType::cases()[0]->value }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="eventCountDropdown">
                    @foreach (\App\Enums\FirstAnalyticsType::cases() as $index => $case)
                        <li class="dropdown-item" data-value="{{ $case->name }}">{{ $case->value }}</li>
                    @endforeach
                </ul>
                <div class="px-3 fw-bold firstTotal" style="font-size: 22px"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="filter-card dropdown">
                <button class="btn dropdown-toggle mt-2" id="secondType" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" data-value="{{ \App\Enums\SecondAnalyticsType::cases()[0]->name }}">
                    {{ \App\Enums\SecondAnalyticsType::cases()[0]->value }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="eventCountDropdown">
                    @foreach (\App\Enums\SecondAnalyticsType::cases() as $index => $case)
                        <li class="dropdown-item" data-value="{{ $case->name }}">{{ $case->value }}</li>
                    @endforeach
                </ul>
                <div class="px-3 fw-bold secondTotal" style="font-size: 22px"></div>
            </div>
        </div>

        <div class="col-md-6 py-2">
            <div id="reportrange" name="reportrange" class="dropdown-toggle"
                style="cursor: pointer; padding: 7px 13px;">
                <i class='bx bxs-calendar'></i>&nbsp;
                <span id="date_range_filter"></span>
                ( <span id="formatted_date_range" style="font-size: 13px"></span> )
                <input type="hidden" id="from_date" name="from_date">
                <input type="hidden" id="to_date" name="to_date">
            </div>
        </div>

    </div>
</div>

{{-- -------------------chart section------------------------------ --}}
@include('_helpers.loading')

<div class="row mt-5">
    <div id="filter_all_metrics" class="chart-container col-md-6"></div>
    <div id="piechart" class="pie-chart-container col-md-6"></div>
</div>

@push('custom_js')
    @include('_helpers.datepicker', ['id' => 'reportrange'])

    <script>
        $(document).ready(function() {

            $('.filter-card, .dropdown-item').on('click', function() {
                if ($(this).hasClass('active') || $(this).hasClass('active-line')) {
                    return; // Exit the function if the element is already active, preventing to send the same request when clicked multiple times
                }
                $('.filter-card, .dropdown-item').removeClass('active active-line');
                $(this).addClass($(this).hasClass('filter-card') ? 'active-line' : 'active');

                fetchDataAndRenderChart();

                // same code for setting the clicked list item name & value  to the button for both dropdown and filter card
                if ($(this).hasClass('dropdown-item')) {
                    const value = $(this).data('value');
                    const text = $(this).text();
                    const button = $(this).closest('.dropdown').find('.btn.dropdown-toggle');
                    button.data('value', value).text(text).attr('data-value', value);
                }
            });

            $('#reportrange').on('apply.daterangepicker', function() {
                fetchDataAndRenderChart();
            });

            function fetchDataAndRenderChart() {
                showLoading();
                hideChart();
                // Find the active-line card
                const activeCard = $('.filter-card.active-line');

                $.ajax({
                    url: "{{ route('home.draw-chart') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        firstType: activeCard.find('#firstType').data('value'),
                        secondType: activeCard.find('#secondType').data('value'),
                        from_date: $('#from_date').val(),
                        to_date: $('#to_date').val()
                    },
                    success: function(response) {
                        renderChart(response);
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            //---------------Dynamic Bar Chart--------------
            function renderChart(response) {
                const firstTotalDiv = $('.filter-card.active-line .firstTotal');
                const secondTotalDiv = $('.filter-card.active-line .secondTotal');

                if (!response.data || response.data.length === 0) {
                    hideLoading();
                    firstTotalDiv.text(0);
                    secondTotalDiv.text(0);
                    swal.fire(
                        'No data found for the selected date range. Please try with different date range to see the chart',
                        '', 'error');
                    return;
                }
                const dates = response.data.map(item => item.date);
                const seriesNames = Object.keys(response.data[0]).filter(key => key !== 'date');
                const series = seriesNames.map(name => ({
                    name,
                    data: response.data.map(item => parseFloat(item[name]) * (name ===
                        'engagementRate' || name === 'bounceRate' ? 100 : 1))

                }));
                const seriesTotals = series.map(serie => {
                    const total = serie.data.reduce((a, b) => a + b, 0);
                    if (serie.name === 'engagementRate' || serie.name === 'bounceRate') {
                        return total / response.data.length; // Calculate average
                    }
                    return total;
                });

                if (Array.isArray(seriesTotals) && seriesTotals.length > 0) {
                    const metricFormatting = {
                        'engagementRate': 1, // One decimal place
                        'bounceRate': 1,
                        'eventCountPerUser': 1,
                        'eventsPerSession': 1,
                        'averageSessionDuration': 1,
                    };
                    const decimalPlaces = metricFormatting[seriesNames] || 0; // Default to 0 decimals

                    firstTotalDiv.text(seriesTotals[0].toFixed(decimalPlaces));
                    secondTotalDiv.text(seriesTotals[0].toFixed(decimalPlaces));
                }

                var options = {
                    series: series,
                    chart: {
                        type: 'line',
                        height: 350,
                        zoom: {
                            enabled: true
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    markers: {
                        size: 5
                    },
                    title: {
                        text: seriesNames + ' of ' + $('#date_range_filter').html(),
                        align: 'left'
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        },
                        title: {
                            text: seriesNames,
                        }
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: dates,
                        title: {
                            text: $('#date_range_filter').html(),
                        },
                    },
                    // tooltip: {
                    //     shared: false,
                    //     y: {
                    //         formatter: function(val) {
                    //             return val.toFixed(2);
                    //         }
                    //     }
                    // }
                };

                setTimeout(function() {
                    var filter_all_metrics = new ApexCharts(document.querySelector(
                            "#filter_all_metrics"),
                        options);
                    filter_all_metrics.render().then(function() {
                        hideLoading();
                        showChart();
                    });
                }, 1000);
            }
            // Initial chart rendering
            fetchDataAndRenderChart();

            //------------- Helper functions ----------------

            function showChart() {
                $('.chart-container').show();
            }

            function hideChart() {
                $('.chart-container').hide();
            }

            function showPieChart() {
                $('.pie-chart-container').show();
            }

            function hidePieChart() {
                $('.pie-chart-container').hide();
            }

            //---------- Pie chart functions--------------------------
            const userTypeData = @json($userType);

            const {
                newVisitors,
                returningVisitors,
                dates,
                totalNewVisitors,
                totalReturningVisitors
            } = userTypeData.reduce((acc, item) => {
                if (item.newVsReturning === 'new') {
                    acc.newVisitors.push(item.activeUsers);
                    acc.totalNewVisitors += item.activeUsers;
                } else if (item.newVsReturning === 'returning') {
                    acc.returningVisitors.push(item.activeUsers);
                    acc.totalReturningVisitors += item.activeUsers;
                }
                return acc;
            }, {
                newVisitors: [],
                returningVisitors: [],
                dates: [],
                totalNewVisitors: 0,
                totalReturningVisitors: 0
            });

            var options = {
                series: [totalNewVisitors, totalReturningVisitors],
                chart: {
                    width: '100%',
                    type: 'pie',
                },
                labels: ["New", "Returning"],
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
                    text: "New vs Returning Visitors",
                    align: 'center'
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        return [name, val.toFixed(1) + '%']
                    }
                },
                legend: {
                    show: false
                }
            };

            setTimeout(() => {
                var piechart = new ApexCharts(document.querySelector("#piechart"), options);
                piechart.render().then(function() {
                    hideLoading();
                    showPieChart();
                });

            }, 1000);
        });
    </script>
@endpush

<style>
    .active-line {
        background-color: rgba(105, 108, 255, 0.16) !important;
    }

    .active-line::before {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 5px;
        background-color: blue;
    }

    .dropdown-item.active {
        background-color: rgba(105, 108, 255, 0.16) !important;
    }

    .chart-container {
        display: none;
    }

    .pie-chart-container {
        display: none;
    }
</style>
