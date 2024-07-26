@extends('layouts.master')
@section('title', 'Experience')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Experience"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.experiences.create') }}" class="btn btn-sm btn-dark mb-2"><i
                            class='bx bx-xs bx-plus'> </i>Create</a>
                </div>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name','role','from - to', 'display_order', 'status', 'Actions']" />

                        <tbody id="tablecontents">
                            @forelse ($experiences as $experience)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <x-table.td>{{ $experience->name }}</x-table.td>

                                    <x-table.td>{{ $experience->role }}</x-table.td>

                                    <x-table.td>{{$experience->date_from .'-'. ($experience->curently_here ? 'Present' : $experience->date_to )}}</x-table.td>

                                    <x-table.td>{{ $experience->display_order }}</x-table.td>

                                    <x-table.switch :model="$experience" />

                                    <td style="width:150px">
                                        <div class="actions d-flex">
                                            <x-table.view_btn route-view="{{ route('admin.experiences.show', ':id') }}"
                                                id="{{ $experience->id }}" model="Experience" name="experience" />

                                            <x-table.edit_btn
                                                route-edit="{{ route('admin.experiences.edit', $experience->id) }}" />

                                            <x-table.delete_btn
                                                route-destroy="{{ route('admin.experiences.destroy', $experience->id) }}" />
                                        </div>
                                    </td>
                                </tr>

                                <x-table.show_modal id="{{ $experience->id }}" model="Experience" />

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
        'name' => 'experience',
        'route' => route('admin.experiences.show', ':id'),
    ])
    @include('_helpers.datatable')
    @include('_helpers.status_change', ['url' => url('Admin/status-change-experience')])
    @include('_helpers.swal_delete')
@endpush
