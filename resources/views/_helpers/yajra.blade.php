<script>
    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'throw';

        $('#datatable').DataTable({
            data: {
                "_token": "{{ csrf_token() }}"
            },
            deferRender: true,
            responsive: true,
            pageLength: 10,
            pagingType: "full_numbers",
            lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']],
            searchDelay: 600,
            processing: true,
            serverSide: true,
            ajax: "{{$url}}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    @foreach ($columns as $column)
                {
                    data: '{{ $column }}', name: '{{ $column }}'
                },
                    @endforeach
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                },
            ],
        });
    });
</script>
