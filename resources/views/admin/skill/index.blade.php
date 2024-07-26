@extends('layouts.master')
@section('title', 'Skill')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Skill"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.skills.create') }}" class="btn btn-sm btn-dark mb-2"><i class='bx bx-xs bx-plus'>
                        </i>Create</a>
                </div>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['name', 'percentage','display_order', 'status', 'Actions']" />

                        <tbody id="tablecontents">
                            @forelse ($skills as $skill)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <x-table.td>{{ $skill->name }}</x-table.td>

                                    <x-table.td>{{ $skill->percentage }}</x-table.td>
                                    <x-table.td>{{ $skill->display_order }}</x-table.td>

                                  <x-table.switch :model="$skill" />

                                    <td style="width:150px">
                                        <div class="actions d-flex">
                                            <x-table.view_btn route-view="{{ route('admin.skills.show', ':id') }}"
                                                id="{{ $skill->id }}" model="Skill" name="skill" />

                                            <x-table.edit_btn route-edit="{{ route('admin.skills.edit', $skill->id) }}" />

                                            <x-table.delete_btn
                                                route-destroy="{{ route('admin.skills.destroy', $skill->id) }}" />
                                        </div>
                                    </td>
                                </tr>

                                <x-table.show_modal id="{{ $skill->id }}" model="Skill" />

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
    @include('_helpers.modal_script', ['name' => 'skill', 'route' => route('admin.skills.show', ':id')])
    @include('_helpers.datatable')
    @include('_helpers.status_change', ['url' => url('Admin/status-change-skill')])
    @include('_helpers.swal_delete')
@endpush
