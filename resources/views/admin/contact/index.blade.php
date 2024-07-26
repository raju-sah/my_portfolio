@extends('layouts.master')
@section('title', 'Contact')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Contact"></x-breadcrumb>

        <div class="card">

            <div class="card-body">
                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name','email', 'phone','Actions']"/>

                        <tbody id="tablecontents"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    @include('_helpers.modal_script', [
        'name' => 'contact',
        'route' => route('admin.contacts.show', ':id'),
    ])
     @include('_helpers.yajra',['url' => route("admin.contacts.index"), 'columns' => $columns])

    @include('_helpers.swal_delete')
@endpush
