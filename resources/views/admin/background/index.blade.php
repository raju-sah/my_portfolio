@extends('layouts.master')
@section('title', 'Background')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Background"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.backgrounds.create') }}" class="btn btn-sm btn-dark mb-2"><i
                            class='bx bx-xs bx-plus'> </i>Create</a>
                </div>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name', 'address', 'web_url', 'status', 'Actions']" />

                        <tbody id="tablecontents">
                            @forelse ($backgrounds as $background)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <x-table.td>{{ $background->name }}</x-table.td>

                                        <x-table.td>{{ $background->address }}</x-table.td>

                                    <x-table.td>{{ $background->web_url }}</x-table.td>

                                    <x-table.switch :model="$background" />

                                    <td style="width:150px">
                                        <div class="actions d-flex">
                                            <x-table.view_btn route-view="{{ route('admin.backgrounds.show', ':id') }}"
                                                id="{{ $background->id }}" model="Background" name="background" />

                                            <x-table.edit_btn
                                                route-edit="{{ route('admin.backgrounds.edit', $background->id) }}" />

                                            <x-table.delete_btn
                                                route-destroy="{{ route('admin.backgrounds.destroy', $background->id) }}" />
                                        </div>
                                    </td>
                                </tr>

                                <x-table.show_modal id="{{ $background->id }}" model="Background" />

                            @empty
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    @include('_helpers.modal_script', [
        'name' => 'background',
        'route' => route('admin.backgrounds.show', ':id'),
    ])
    @include('_helpers.datatable')
    @include('_helpers.status_change', ['url' => url('Admin/status-change-background')])
    @include('_helpers.swal_delete')
@endpush
