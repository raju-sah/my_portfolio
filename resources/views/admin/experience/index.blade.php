@extends('layouts.master')
@section('title', 'Experience')

@push('custom_css')
    <style>
        .sortable-handle {
            cursor: move;
            color: #696cff;
            font-size: 1.2rem;
        }

        .sortable-ghost {
            opacity: 0.4;
            background-color: #f4f4f4;
            border: 2px dashed #696cff;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Experience"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.experiences.create') }}" class="btn btn-sm btn-dark mb-2"><i
                            class='bx bx-xs bx-plus'> </i>Create</a>
                </div>

                {{-- Form for updating order --}}
                <form action="{{ route('admin.experiences.update-order') }}" method="POST" id="experience-order-form">
                    @csrf
                </form>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <thead class="bg-primary text-white text-uppercase">
                            <tr>
                                <th style="width: 50px"></th>
                                <th style="width: 50px">#</th>
                                <th>name</th>
                                <th>role</th>
                                <th>from - to</th>
                                <th>display_order</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="experience-sortable-list">
                            @forelse ($experiences as $experience)
                                <tr data-id="{{ $experience->id }}">
                                    <td>
                                        <i class="bx bx-menu sortable-handle"></i>
                                        <input type="hidden" name="order[]" value="{{ $experience->id }}"
                                            form="experience-order-form">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>

                                    <x-table.td>{{ $experience->name }}</x-table.td>

                                    <x-table.td>{{ $experience->role }}</x-table.td>

                                    <x-table.td>
                                        {{ $experience->date_from . '-' . ($experience->curently_here ? 'Present' : $experience->date_to) }}
                                    </x-table.td>

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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('experience-sortable-list');
            if (list) {
                new Sortable(list, {
                    handle: '.sortable-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function() {
                        const form = document.getElementById('experience-order-form');
                        if (form) {
                            form.submit();
                        }
                    }
                });
            }
        });
    </script>
    @include('_helpers.modal_script', [
        'name' => 'experience',
        'route' => route('admin.experiences.show', ':id'),
    ])
    @include('_helpers.datatable')
    @include('_helpers.status_change', ['url' => url('Admin/status-change-experience')])
    @include('_helpers.swal_delete')
@endpush
