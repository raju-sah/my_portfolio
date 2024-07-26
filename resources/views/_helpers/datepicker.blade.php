<script type="text/javascript">
    $(function() {

        const start = moment().subtract(6, 'days');
        const end = moment();

        function cb(start, end, label) {
            const formattedRange = start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY');
            $('#from_date').val(start.format('YYYY-MM-DD'));
            $('#to_date').val(end.format('YYYY-MM-DD'));

            if (label) {
                $('#date_range_filter').html(label);
                $('#formatted_date_range').html(formattedRange);
            } else {
                $('#date_range_filter').html(formattedRange);
                $('#formatted_date_range').html('');
            }
        }

        $('#{{ $id }}').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week')
                    .endOf('week')
                ],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')],
                'This 6 Months': [moment().subtract(6, 'months').startOf('month'), moment()],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf(
                    'month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                    .endOf('year')
                ],
                'Since Birth': [moment('2024-05-31'), moment()]
            }
        }, cb);

        var defaultLabel = 'Last 7 Days';
        cb(start, end, defaultLabel);

    });
</script>
