@extends('layouts.master')
@section('title', 'Article Review')
@section('content')

    <div class="container-xxl">

        <x-breadcrumb model="Review"></x-breadcrumb>

        <div class="card">
            <div class="card-body">
                <select id="filter_by_article" class="form-select w-50 mb-3 select_two_articles" name="article">
                    @foreach ($articles as $id => $article)
                        <option value="{{ $id }}">{{ $article }}</option>
                    @endforeach
                </select>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name', 'email', 'rating', 'article', 'status', 'Actions']" />

                        <tbody id="tablecontents"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom_css')
    <style>
        .select2-container--default .select2-selection--single {
            margin-bottom: 30px;
        }
    </style>
@endpush

@push('custom_js')
    @include('_helpers.modal_script', ['name' => 'review', 'route' => route('admin.reviews.show', ':id')])
    @include('_helpers.swal_delete')
    @include('_helpers.status_change', ['url' => url('Admin/status-change-review')])

    <script>
        $(document).ready(function() {
            $('.select_two_articles').select2({
                placeholder: 'Select Article to filter Reviews',
            }).val("{{ old('article') }}").trigger('change');
        });
    </script>

    <script>
        $(document).ready(function() {

            // datatable
            $.fn.dataTable.ext.errMode = 'throw';

            var table = $('#datatable').DataTable({
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
                    url: "{{ route('admin.reviews.index') }}",
                    data: function(d) {
                        d.filter_by_article = $('#filter_by_article').val();
                        console.log(d);
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'rating',
                        name: 'rating'
                    },
                    {
                        data: 'article_name',
                        name: 'article_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#filter_by_article').change(function() {
                table.draw();
            });
        });
    </script>
@endpush
