@extends('layouts.master')
@section('title', 'Article Report Filters')
@section('content')

    <div class="container-xxl">

        <x-breadcrumb model="Article Filters"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <form id="filter_form" class="mb-4" method="GET">
                    <x-form.row>
                        <x-form.enum-select id="common_filter" col="3" :option-display="false" :options="App\Enums\CommonFilterType::cases()"
                            name="common_filter" required />
                        <div class="col-md-4 d-flex align-items-end mb-4 mt-4">
                            <div id="reportrange" name="reportrange" class="form-select"
                                style="cursor: pointer; padding: 7px 13px;">
                                <i class='bx bxs-calendar'></i>&nbsp;
                                <span id="date_range_filter"></span>
                                <input type="hidden" id="from_date" name="from_date">
                                <input type="hidden" id="to_date" name="to_date">
                            </div>
                        </div>
                        <div class=" col-md-2 mt-4 ">
                            <select id="asc_desc_filter" class="form-select">
                                @foreach (\App\Enums\AscDescFilterType::cases() as $ascDesc)
                                    <option value="{{ $ascDesc->value }}">{{ $ascDesc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <x-form.button class="btn btn-sm btn-info w-50 " style="height: 35px;" type="submit"><i
                                    class='bx bx-xs bx-filter-alt'></i> Filter</x-form.button>
                        </div>
                    </x-form.row>
                </form>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">
                        <x-table.header :headers="['title', 'slug', 'views', 'Avg Rating', 'Created at', 'Report']" />
                        <tbody id="tablecontents"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom_js')
    @include('_helpers.modal_script', [
        'name' => 'article',
        'route' => route('admin.articles.show', ':id'),
    ])
    @include('_helpers.status_change', ['url' => url('admin/status-change-article')])
    @include('_helpers.swal_delete')
    @include('_helpers.datepicker', ['id' => 'reportrange'])

    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'throw';

            var table = $('#datatable').DataTable({
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                deferRender: true,
                responsive: true,
                pageLength: 10,
                pagingType: "full_numbers",
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, 'All']
                ],
                searchDelay: 600,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.article-reports.filters') }}",

                    data: function(d) {
                        d.common_filter = $('#common_filter').val();
                        d.asc_desc_filter = $('#asc_desc_filter').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'views',
                        name: 'views',
                    },
                    {
                        data: 'avg_rating',
                        name: 'avg_rating'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'report_button',
                        name: 'report_button'
                    },
                ],
            });

            $('#filter_form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });

        });
    </script>
@endpush
