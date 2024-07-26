
@if(is_null($request->common_filter) && is_null($request->pagination_filter))
@if ($all_articles->isNotEmpty())
    <h4 class="mx-5">All Articles</h4>
    <hr>
    <div class="d-flex flex-wrap justify-content-center align-items-center">
        @foreach ($all_articles as $all_article)
            <div class="card  article-card col-11  col-sm-11 col-md-5 col-xxl-4 mb-3 mx-2 col-xxl-3">
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
                <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3">
                    <span>{{ optional($all_article)->min_read }} min read</span>
                    <span>&nbsp; · &nbsp;</span>
                    <span>{{ optional($all_article)->created_at->format('d M Y') }},</span>
                    <span class="ms-2"><a href="{{ route('article.detail', optional($all_article)->slug) }}"><i
                                class="fa-regular fa-eye"></i></a>&nbsp;{{ $views['screenPageViews']?? '0' }}&nbsp;Views</span>
                </div>
                <div class="article-description">{!! optional($all_article)->description !!}</div>
                <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                    @foreach (explode(',', optional($all_article)->about) as $about)
                        <span class="badge m-1">{{ $about }}</span>
                    @endforeach
                </div>
                <a href="{{ route('article.detail', optional($all_article)->slug) }}"
                    class="text-decoration-none d-flex justify-content-end">Read More....</a>
            </div>
        @endforeach
    </div>
@else
    <span style="color: #a6adbb">No Articles Found
       
@endif
@endif