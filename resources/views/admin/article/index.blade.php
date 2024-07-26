@extends('layouts.master')
@section('title', 'Article')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Article"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-dark mb-2"><i
                            class='bx bx-xs bx-plus'> </i>Create</a>
                </div>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name', 'min_read', 'about', 'display_order', 'views', 'status', 'Actions']" />

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
     @include('_helpers.yajra',['url' => route("admin.articles.index"), 'columns' => $columns])
     @include('_helpers.status_change', ['url' => url('Admin/status-change-article')])
    @include('_helpers.swal_delete')
@endpush

