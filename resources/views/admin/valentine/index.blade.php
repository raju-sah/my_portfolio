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

        <!-- Top Days -->
        @if($topDays->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">📊 Top Days by Submissions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $dayConfig = \App\Models\ValentineSubmission::getDayConfig();
                    @endphp
                    @foreach($topDays as $day)
                        @php
                            $config = $dayConfig[$day->day_type] ?? null;
                        @endphp
                        <div class="col-md-2">
                            <div class="text-center p-3 border rounded">
                                <span style="font-size: 2rem;">{{ $config ? $config['emoji'] : '❤️' }}</span>
                                <h6>{{ $config ? $config['name'] : $day->day_type }}</h6>
                                <span class="badge bg-primary">{{ $day->count }} submissions</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

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
    @include('_helpers.yajra',['url' => route("admin.valentines.index"), 'columns' => $columns])
    @include('_helpers.swal_delete')
@endpush
