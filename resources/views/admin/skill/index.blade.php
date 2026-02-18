@extends('layouts.master')
@section('title', 'Skill')

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

        /* Modern Pill Tabs */
        .admin-type-tabs {
            border-bottom: none !important;
            background: rgba(0, 0, 0, 0.05);
            padding: 5px;
            border-radius: 50px;
            display: inline-flex;
            margin-bottom: 2rem;
        }

        .admin-type-tabs .nav-item {
            margin-bottom: 0;
        }

        .admin-type-tabs .nav-link {
            border: none !important;
            border-radius: 50px !important;
            padding: 8px 25px !important;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d !important;
        }

        .admin-type-tabs .nav-link.active {
            background: #696cff !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3) !important;
        }

        .admin-type-tabs .badge-count {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        .admin-type-tabs .nav-link.active .badge-count {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl">
        <x-breadcrumb model="Skill"></x-breadcrumb>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Manage Skills</h5>
                    <a href="{{ route('admin.skills.create') }}" class="btn btn-sm btn-dark">
                        <i class='bx bx-xs bx-plus'></i> Create
                    </a>
                </div>

                {{-- Nav Tabs Centered --}}
                <div class="d-flex justify-content-center">
                    <ul class="nav nav-tabs admin-type-tabs" id="skillTabs" role="tablist">
                        @foreach (\App\Enums\SkillDomain::cases() as $domain)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $domain->value }}"
                                    data-bs-toggle="tab" data-bs-target="#content-{{ $domain->value }}" type="button"
                                    role="tab">
                                    <i class='bx bx-category'></i>
                                    {{ $domain->label() }}
                                    <span class="badge-count">{{ count($skills[$domain->value] ?? []) }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="skillTabsContent">
                    @foreach (\App\Enums\SkillDomain::cases() as $domain)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $domain->value }}"
                            role="tabpanel">
                            
                            {{-- Form for updating order - placed OUTSIDE the table to avoid nesting forms --}}
                            <form action="{{ route('admin.skills.update-order') }}" method="POST" id="order-form-{{ $domain->value }}">
                                @csrf
                            </form>

                            <div class="table-responsive no-wrap">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px"></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Percentage</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable-list">
                                        @forelse ($skills[$domain->value] ?? [] as $skill)
                                            <tr data-id="{{ $skill->id }}">
                                                <td>
                                                    <i class="bx bx-menu sortable-handle"></i>
                                                    {{-- Link this input to the form above using the form attribute --}}
                                                    <input type="hidden" name="order[]" value="{{ $skill->id }}" form="order-form-{{ $domain->value }}">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $skill->name }}</td>
                                                <td>
                                                    <div class="progress" style="height: 8px; width: 100px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" 
                                                            style="width: {{ $skill->percentage }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $skill->percentage }}%</small>
                                                </td>
                                                <td>
                                                    <x-table.switch :model="$skill" />
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <x-table.view_btn route-view="{{ route('admin.skills.show', ':id') }}"
                                                            id="{{ $skill->id }}" model="Skill" name="skill" />
                                                        <x-table.edit_btn route-edit="{{ route('admin.skills.edit', $skill->id) }}" />
                                                        <x-table.delete_btn route-destroy="{{ route('admin.skills.destroy', $skill->id) }}" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <x-table.show_modal id="{{ $skill->id }}" model="Skill" />
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">No skills found in this category.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortables = document.querySelectorAll('.sortable-list');
            sortables.forEach(list => {
                new Sortable(list, {
                    handle: '.sortable-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function() {
                        // Auto-submit the linked form
                        const firstInput = list.querySelector('input[name="order[]"]');
                        if (firstInput && firstInput.form) {
                            firstInput.form.submit();
                        }
                    }
                });
            });
        });
    </script>
    @include('_helpers.modal_script', ['name' => 'skill', 'route' => route('admin.skills.show', ':id')])
    @include('_helpers.status_change', ['url' => url('Admin/status-change-skill')])
    @include('_helpers.swal_delete')
@endpush