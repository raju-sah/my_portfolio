@extends('layouts.master')
@section('title', 'Project')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Project"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-dark mb-2"><i
                            class='bx bx-xs bx-plus'> </i>Create</a>
                </div>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name', 'year', 'tech_used', 'display_order', 'status', 'Actions']" />

                        <tbody id="tablecontents"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    @include('_helpers.modal_script', [
        'name' => 'project',
        'route' => route('admin.projects.show', ':id'),
    ])
    @include('_helpers.yajra', ['url' => route('admin.projects.index'), 'columns' => $columns])
    @include('_helpers.status_change', ['url' => url('Admin/status-change-project')])
    @include('_helpers.swal_delete')
@endpush
