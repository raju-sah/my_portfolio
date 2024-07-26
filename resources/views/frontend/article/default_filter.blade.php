@if (is_null($request->common_filter) && $request->has('asc_desc_filter'))
    @if ($default_results->isNotEmpty())
        <h4 class="mx-3">
            {{ $request->pagination_filter == -1 ? 'All' : $request->pagination_filter }}
            Most {{ $request->asc_desc_filter == 'desc' ? 'Recent' : 'Old' }} Articles
        </h4>
        <hr>
        <div class="d-flex flex-wrap justify-content-center align-items-center">
            @foreach ($default_results as $default_result)
                <div class="card  article-card col-11  col-sm-11 col-md-5 col-xxl-4 mb-3 mx-2 col-xxl-3">
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
                    <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3">
                        <span>{{ optional($default_result)->min_read }} min read</span>
                        <span>&nbsp; · &nbsp;</span>
                        <span>{{ optional($default_result)->created_at->format('d M Y') }},</span>
                        <span class="ms-2"><a href="{{ route('article.detail', optional($default_result)->slug) }}"><i
                                    class="fa-regular fa-eye"></i></a>&nbsp;{{$views['screenPageViews'] ?? '0' }}&nbsp;Views</span>
                    </div>
                    <div class="article-description">{!! optional($default_result)->description !!}</div>
                    <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                        @foreach (explode(',', $default_result->about) as $about)
                            <span class="badge m-1">{{ $about }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('article.detail', optional($default_result)->slug) }}"
                        class="text-decoration-none d-flex justify-content-end">Read More....</a>
                </div>
            @endforeach
        </div>
    @else
        <span style="color: #a6adbb">No {{ $request->asc_desc_filter == 'desc' ? 'Recent' : 'Old' }} Articles Found For
            {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} -
            {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</span>
    @endif
@endif
