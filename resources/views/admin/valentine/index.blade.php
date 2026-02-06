@extends('layouts.master')
@section('title', 'Valentine Reports')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Valentine Reports"></x-breadcrumb>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total'] }}</h3>
                        <p class="mb-0">Total Sent</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['accepted'] }}</h3>
                        <p class="mb-0">Accepted</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['rejected'] }}</h3>
                        <p class="mb-0">Rejected</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h3>{{ $stats['pending'] }}</h3>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total_opens'] }}</h3>
                        <p class="mb-0">Total Opens</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total_likes'] }}</h3>
                        <p class="mb-0">Total Likes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Day Tabs -->
        <div class="card mb-4">
            <div class="card-body p-2">
                <ul class="nav nav-pills nav-fill gap-2" id="dayTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill border" id="all-tab" data-bs-toggle="tab" data-day="" type="button" role="tab" aria-selected="true">
                            🏠 All Days
                            <span class="badge bg-secondary ms-1">{{ $stats['total'] }}</span>
                        </button>
                    </li>
                    @foreach($dayConfig as $key => $day)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill border nav-link-{{ $key }}" id="{{ $key }}-tab" data-bs-toggle="tab" data-day="{{ $key }}" type="button" role="tab" aria-selected="false">
                                {{ $day['emoji'] }} {{ $day['name'] }}
                                <span class="badge bg-light text-dark ms-1">{{ $day['count'] }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <style>
            #dayTabs .nav-link {
                transition: all 0.3s ease;
                font-weight: 500;
                color: #566a7f;
                background: #f5f5f9;
            }
            #dayTabs .nav-link:hover {
                background: #eceef1;
            }
            #dayTabs .nav-link.active {
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                color: white !important;
            }
            #dayTabs .nav-link.active .badge {
                background: rgba(255,255,255,0.3) !important;
                color: white !important;
            }
            
            @foreach($dayConfig as $key => $day)
            .nav-link-{{ $key }}.active {
                background-color: {{ $day['bg_color'] }} !important;
                border-color: {{ $day['bg_color'] }} !important;
            }
            @endforeach
            
            #all-tab.active {
                background-color: #696cff !important;
                border-color: #696cff !important;
            }
        </style>

        <!-- Data Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">
                        <x-table.header :headers="['Sender', 'Day', 'Status', 'Opens', 'Likes', 'Created', 'View', 'Actions']" />
                        <tbody id="tablecontents"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function () {
            let currentDayType = '';

            const table = $('#datatable').DataTable({
                deferRender: true,
                responsive: true,
                pageLength: 10,
                pagingType: "full_numbers",
                lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']],
                searchDelay: 600,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.valentines.index') }}",
                    data: function(d) {
                        d.day_type = currentDayType;
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    @foreach ($columns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                    @endforeach
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });

            $('#dayTabs button').on('shown.bs.tab', function (e) {
                currentDayType = $(e.target).data('day');
                table.ajax.reload();
            });
        });
    </script>
    @include('_helpers.swal_delete')
@endpush
