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

    /* Modern Pill Tabs */
    .type-tabs {
        border-bottom: none !important;
        background: rgba(255, 255, 255, 0.05);
        padding: 5px;
        border-radius: 50px;
        display: inline-flex;
        margin-bottom: 2rem;
    }

    .type-tabs .nav-item {
        margin-bottom: 0;
    }

    .type-tabs .nav-link {
        color: var(--text-body, #555) !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 10px 30px !important;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .type-tabs .nav-link.active {
        background: var(--accent-color, #6c63ff) !important;
        color: #fff !important;
        box-shadow: 0 4px 15px color-mix(in srgb, var(--accent-color) 40%, transparent) !important;
    }

    .type-tabs .badge-count {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 20px;
        background: rgba(0, 0, 0, 0.1);
        font-weight: 700;
    }

    .type-tabs .nav-link.active .badge-count {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Card & Image Hover Effects */
    .article-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        border-radius: 24px !important;
        background-color: var(--bg-card) !important;
        border: 1px solid color-mix(in srgb, var(--text-heading) 8%, transparent) !important;
        padding: 1.25rem;
    }
    
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }

    .hover-scale-110:hover {
        transform: scale(1.1);
    }

    /* Modern Pill Tags Style */
    .article-tag {
        display: inline-block;
        padding: 4px 14px;
        background: color-mix(in srgb, var(--accent-color) 12%, transparent);
        color: var(--accent-color);
        border: 1px solid color-mix(in srgb, var(--accent-color) 20%, transparent);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin: 4px;
        transition: all 0.3s ease;
    }

    .article-tag:hover {
        background: var(--accent-color);
        color: #fff !important;
        transform: translateY(-2px);
    }

</style>
@endpush
@section('title', 'Articles & Stories')

@section('content')
<div class="container-fluid article">
    <br>
    <br>
    <form id="filter_form" action="{{ route('articles.all') }}" class="mb-3 mx-3" method="GET">
        @csrf
        {{-- Preserve active tab across filter submissions --}}
        <input type="hidden" name="tab" id="active_tab_input" value="{{ request('tab', 'article') }}">

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

    {{-- ── Type Tabs ── --}}
    <div class="d-flex justify-content-center mt-4">
        <ul class="nav nav-tabs type-tabs" id="typeTabNav" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab', 'article') === 'article' ? 'active' : '' }}"
                    id="tab-articles-btn" data-bs-toggle="tab" data-bs-target="#tab-articles"
                    type="button" role="tab" data-tab="article">
                    <i class="fa-solid fa-file-lines"></i>
                    Articles
                    <span class="badge-count">{{ $all_articles->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') === 'story' ? 'active' : '' }}"
                    id="tab-stories-btn" data-bs-toggle="tab" data-bs-target="#tab-stories"
                    type="button" role="tab" data-tab="story">
                    <i class="fa-solid fa-book-open"></i>
                    Stories
                    <span class="badge-count">{{ $all_stories->count() }}</span>
                </button>
            </li>
        </ul>
    </div>


    <div class="tab-content" id="typeTabContent">

        {{-- ── Articles Tab ── --}}
        <div class="tab-pane fade {{ request('tab', 'article') === 'article' ? 'show active' : '' }}"
            id="tab-articles" role="tabpanel">

            @include('frontend.article.articles', ['all_articles' => $all_articles])
            @include('frontend.article.default_filter')
            @include('frontend.article.common_filter')

        </div>

        {{-- ── Stories Tab ── --}}
        <div class="tab-pane fade {{ request('tab') === 'story' ? 'show active' : '' }}"
            id="tab-stories" role="tabpanel">

            @if ($all_stories->isNotEmpty())
            <!-- <h4 class="mx-5 mt-4">All Stories</h4>
            <hr> -->
            <div class="d-flex flex-wrap justify-content-center align-items-center">
                @foreach ($all_stories as $story)
                <div class="card article-card col-11 col-sm-11 col-md-6 mb-4 mx-2 overflow-hidden">
                    <a href="{{ route('article.detail', optional($story)->slug) }}" class="block overflow-hidden mb-3" style="height: 220px; border-radius: 18px;">
                        <img src="{{ $story->image_path }}" alt="{{ $story->name }}" class="w-100 h-100 object-fit-cover transition-transform hover-scale-110" style="transition: transform 0.5s ease;">
                    </a>
                    <!-- <span class="badge bg-success mb-2" style="width:fit-content">Story</span> -->
                    <h6 class="card-title">{{ optional($story)->name }}</h6>
                    <div class="d-flex mb-2">
                        <span style="color: #ffc700">
                            @if (optional($story)->reviews_avg_rating === 0)
                            <span>No review yet</span>
                            @else
                            {!! str_repeat('<i class="fa-solid fa-star"></i>', optional($story)->reviews_avg_rating) !!}
                            @endif
                        </span>
                    </div>
                    <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3 text-muted" style="font-size: 0.85rem; gap: 15px;">
                        <span><i class="fa-regular fa-clock me-1 text-accent"></i> {{ optional($story)->min_read }} min read</span>
                        <span><i class="fa-regular fa-calendar-alt me-1 text-accent"></i> {{ optional($story)->created_at->format('d M Y') }}</span>
                        <span><a href="{{ route('article.detail', optional($story)->slug) }}" class="text-muted text-decoration-none"><i class="fa-regular fa-eye me-1 text-primary"></i> {{ $views['screenPageViews'] ?? '0' }} Views</a></span>
                    </div>
                    <div class="article-description text-body/70">{!! optional($story)->description !!}</div>
                    <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                        @foreach (explode(',', optional($story)->about) as $about)
                        <span class="article-tag">{{ trim($about) }}</span>
                        @endforeach
                    </div>

                </div>

                @endforeach
            </div>
            @else
            <span style="color: #a6adbb" class="mx-5 mt-4 d-block">No Stories Found</span>
            @endif

        </div>

    </div>

</div>
@endsection

@push('front_js')
@include('_helpers.datepicker', ['id' => 'reportrange'])
<script>
    // Sync active tab to hidden input so filter form preserves the tab
    document.querySelectorAll('#typeTabNav .nav-link').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('active_tab_input').value = this.getAttribute('data-tab');
        });
    });
</script>
@endpush