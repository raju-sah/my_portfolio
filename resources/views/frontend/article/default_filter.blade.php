@if (is_null($request->common_filter) && $request->has('asc_desc_filter'))
@if ($default_results->isNotEmpty())
<h4 class="mx-3">
    {{ $request->pagination_filter == -1 ? 'All' : $request->pagination_filter }}
    Most {{ $request->asc_desc_filter == 'desc' ? 'Recent' : 'Old' }} Articles
</h4>
<hr>
<div class="row g-4 px-3">
    @foreach ($default_results as $default_result)
    <div class="col-12 col-md-6">
        <div class="card article-card h-100 overflow-hidden">
            <h6 class="card-title">{{ optional($default_result)->name }}</h6>
            <div class="d-flex mb-2">
                <span style="color: #ffc700">
                    @if (optional($default_result)->reviews_avg_rating === 0)
                    <span>No review yet</span>
                    @else
                    {!! str_repeat('<i class="fa-solid fa-star"></i>', optional($default_result)->reviews_avg_rating) !!}
                    @endif
                </span>
            </div>
            <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3 text-muted" style="font-size: 0.85rem; gap: 15px;">
                <span><i class="fa-regular fa-clock me-1 text-accent"></i> {{ optional($default_result)->min_read }} min read</span>
                <span><i class="fa-regular fa-calendar-alt me-1 text-accent"></i> {{ optional($default_result)->created_at->format('d M Y') }}</span>
                <span><a href="{{ route('article.detail', optional($default_result)->slug) }}" class="text-muted text-decoration-none"><i class="fa-regular fa-eye me-1 text-primary"></i> {{ $views['screenPageViews'] ?? '0' }} Views</a></span>
            </div>
            <div class="article-description text-body/70">{!! optional($default_result)->description !!}</div>
            <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap mt-auto">
                @foreach (explode(',', $default_result->about) as $about)
                <span class="article-tag">{{ trim($about) }}</span>
                @endforeach
            </div>
            <a href="{{ route('article.detail', optional($default_result)->slug) }}"
                class="text-decoration-none d-flex justify-content-end mt-auto">Read More....</a>
        </div>
    </div>
    @endforeach
</div>
@else
<span style="color: #a6adbb">No {{ $request->asc_desc_filter == 'desc' ? 'Recent' : 'Old' }} Articles Found For
    {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} -
    {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</span>
@endif
@endif