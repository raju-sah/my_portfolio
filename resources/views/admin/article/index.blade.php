@extends('layouts.master')
@section('title', 'Article')

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
        <x-breadcrumb model="Article"></x-breadcrumb>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Manage Articles & Stories</h5>
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-dark">
                        <i class='bx bx-xs bx-plus'></i> Create
                    </a>
                </div>

                {{-- Nav Tabs Centered --}}
                <div class="d-flex justify-content-center">
                    <ul class="nav nav-tabs admin-type-tabs" id="articleTabs" role="tablist">
                        @foreach (\App\Enums\ArticleType::cases() as $type)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $type->value }}"
                                    data-bs-toggle="tab" data-bs-target="#content-{{ $type->value }}" type="button"
                                    role="tab">
                                    <i class='bx {{ $type->value === 'article' ? 'bx-file-blank' : 'bx-book-reader' }}'></i>
                                    {{ $type->label() }}
                                    <span class="badge-count">{{ count($articles[$type->value] ?? []) }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Tab Content --}}
                <div class="tab-content" id="articleTabsContent">
                    @foreach (\App\Enums\ArticleType::cases() as $type)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $type->value }}"
                            role="tabpanel">
                            
                            {{-- Form for updating order --}}
                            <form action="{{ route('admin.articles.update-order') }}" method="POST" id="order-form-{{ $type->value }}">
                                @csrf
                            </form>

                            <div class="table-responsive no-wrap">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px"></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Min Read</th>
                                            <th>Display Order</th>
                                            <th>Views</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable-list">
                                        @forelse ($articles[$type->value] ?? [] as $article)
                                            <tr data-id="{{ $article->id }}">
                                                <td>
                                                    <i class="bx bx-menu sortable-handle"></i>
                                                    <input type="hidden" name="order[]" value="{{ $article->id }}" form="order-form-{{ $type->value }}">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $article->name }}</td>
                                                <td>{{ $article->min_read }} min</td>
                                                <td>{{ $article->display_order }}</td>
                                                <td>{{ $article->views }}</td>
                                                <td>
                                                    <x-table.switch :model="$article" />
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <x-table.view_btn route-view="{{ route('admin.articles.show', ':id') }}"
                                                            id="{{ $article->id }}" model="Article" name="article" />
                                                        <x-table.edit_btn route-edit="{{ route('admin.articles.edit', $article->id) }}" />
                                                        <x-table.delete_btn route-destroy="{{ route('admin.articles.destroy', $article->id) }}" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <x-table.show_modal id="{{ $article->id }}" model="Article" />
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">No entries found in this category.</td>
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
                        const firstInput = list.querySelector('input[name="order[]"]');
                        if (firstInput && firstInput.form) {
                            firstInput.form.submit();
                        }
                    }
                });
            });
        });
    </script>
    @include('_helpers.modal_script', ['name' => 'article', 'route' => route('admin.articles.show', ':id')])
    @include('_helpers.status_change', ['url' => url('Admin/status-change-article')])
    @include('_helpers.swal_delete')
@endpush