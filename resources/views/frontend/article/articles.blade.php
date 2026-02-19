@if(is_null($request->common_filter) && is_null($request->pagination_filter))
@if ($all_articles->isNotEmpty())
<!-- <h4 class="mx-5">All Articles</h4>
    <hr> -->
<div class="row g-4">
    @foreach ($all_articles as $all_article)
    <div class="col-12 col-md-6">
        <div class="card article-card h-100 overflow-hidden">
            <a href="{{ route('article.detail', optional($all_article)->slug) }}" class="block overflow-hidden mb-3" style="height: 220px; border-radius: 18px;">
                <img src="{{ $all_article->image_path }}" alt="{{ $all_article->name }}" class="w-100 h-100 object-fit-cover transition-transform hover-scale-110" style="transition: transform 0.5s ease;">
            </a>
            <h6 class="card-title">{{ optional($all_article)->name }}</h6>

            <div class="d-flex mb-2">
                <span style="color: #ffc700">
                    @if (optional($all_article)->reviews_avg_rating === 0)
                    <span>No review yet</span>
                    @else
                    {!! str_repeat('<i class="fa-solid fa-star"></i>', optional($all_article)->reviews_avg_rating) !!}
                    @endif
                </span>
            </div>
            <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3 text-muted" style="font-size: 0.85rem; gap: 15px;">
                <span><i class="fa-regular fa-clock me-1 text-accent"></i> {{ optional($all_article)->min_read }} min read</span>
                <span><i class="fa-regular fa-calendar-alt me-1 text-accent"></i> {{ optional($all_article)->created_at->format('d M Y') }}</span>
                <span><a href="{{ route('article.detail', optional($all_article)->slug) }}" class="text-muted text-decoration-none"><i class="fa-regular fa-eye me-1 text-primary"></i> {{ $views['screenPageViews']?? '0' }} Views</a></span>
            </div>
            <div class="article-description text-body/70">{!! optional($all_article)->description !!}</div>
            <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap mt-auto">
                @foreach (explode(',', optional($all_article)->about) as $about)
                <span class="article-tag">{{ trim($about) }}</span>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<span style="color: #a6adbb">No Articles Found

    @endif
    @endif