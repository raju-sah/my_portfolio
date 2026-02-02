@extends('layouts.front_master')
@push('front_css')
    <style>
        .row {
            align-items: end !important;
        }

        .article .form-select {
            background-color: var(--bg-card) !important;
            color: var(--text-body) !important;
            border: 1px solid color-mix(in srgb, var(--text-body) 30%, transparent) !important;
            transition: all 0.3s ease;
        }
        .article .form-select:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 2px color-mix(in srgb, var(--accent-color) 20%, transparent) !important;
        }

        .ranges {
            background: var(--bg-card);
            color: var(--text-heading);
        }

        .ranges li:hover {
            background-color: var(--accent-color) !important;
        }

        .ranges li.active {
            background-color: var(--accent-color) !important;
        }

        .article .btn {
            background-color: var(--accent-color) !important;
            color: #fff !important;
            height: 39px;
            border-radius: 8px !important;
            transition: all 0.3s ease;
        }
        .article .btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        @media(max-width: 768px) {
            .btn {
                left: 0 !important;
            }
        }
    </style>
@endpush
@section('title', 'Articles')

@section('content')
    <div class="container-fluid article">
        <br>
        <br>
        <form id="filter_form" action="{{ route('articles.all') }}" class="mb-3 mx-3" method="GET">
            @csrf
            <div class="row mx-1 justify-content-center">
                <div class="col-md-2">
                    <select id="common_filter" class="form-select mb-3" name="common_filter">
                        <option value="">Select</option>
                        @foreach (\App\Enums\CommonFilterType::cases() as $common_filter)
                            <option value="{{ $common_filter->value }}"
                                {{ old('common_filter', $request->common_filter) == $common_filter->value ? 'selected' : '' }}>
                                {{ $common_filter->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end mb-3">
                    <div id="reportrange" name="reportrange" class="form-select" style="cursor: pointer;">
                        <i class="fa-solid fa-calendar-days"></i>&nbsp;
                        <span id="date_range_filter" name="date_range_filter"></span>
                    </div>
                    <!-- Hidden input fields to store date range values -->
                    <input type="hidden" id="from_date" name="from_date">
                    <input type="hidden" id="to_date" name="to_date">
                </div>
                <div class="col-md-2">
                    <select id="asc_desc_filter" class="form-select mb-3" name="asc_desc_filter">
                        @foreach (\App\Enums\AscDescFilterType::cases() as $ascDesc)
                            <option value="{{ $ascDesc->value }}"
                                {{ old('asc_desc_filter', $request->asc_desc_filter) == $ascDesc->value ? 'selected' : '' }}>
                                {{ $ascDesc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="pagination_filter" class="form-select mb-3" name="pagination_filter">
                        @foreach (\App\Enums\PaginationFilterType::cases() as $case)
                            <option value="{{ $case->value }}"
                                {{ old('pagination_filter', $request->pagination_filter) == $case->value ? 'selected' : '' }}>
                                {{ $case->value == -1 ? 'All' : $case->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <x-form.button class="btn w-50"><i class="fa-solid fa-filter"></i>
                    </x-form.button>
                </div>
            </div>

        </form>
        @include('frontend.article.articles')

        @include('frontend.article.default_filter')

        @include('frontend.article.common_filter')

    </div>
@endsection

@push('front_js')
    @include('_helpers.datepicker', ['id' => 'reportrange'])
@endpush
