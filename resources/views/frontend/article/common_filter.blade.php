@if ($request->common_filter !== null)
    <!----------------------Top Most Viewed Articles---------------------->
    @if ($request->common_filter === App\Enums\CommonFilterType::Views->value)
        @if ($most_viewed->isNotEmpty())
            <div>
                <h4 class="mx-3">
                    {{ $request->pagination_filter == -1 ? 'All' : '' . $request->pagination_filter }}
                    {{ $request->asc_desc_filter == 'desc' ? 'Most' : 'Least' }} Viewed Articles
                </h4>
                <hr>
                <div class="d-flex flex-wrap justify-content-center align-items-center">
                    @foreach ($most_viewed as $most_view)
                        <div class="card  article-card col-11  col-sm-11 col-md-5 col-xxl-4 mb-3 mx-2 col-xxl-3">
                            <h6 class="card-title">{{ optional($most_view)->name }}</h6>
                            <div class="d-flex mb-2">
                                <span style="color: #ffc700">
                                    @if (optional($most_view)->reviews_avg_rating === 0)
                                        No review yet
                                    @else
                                        {!! str_repeat('<i class="fa-solid fa-star"></i>', optional($most_view)->reviews_avg_rating) !!}
                                    @endif
                                </span>

                            </div>
                            <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3">
                                @php
                                    optional($most_view)->min_read = optional($most_view)->min_read . ' min read';
                                @endphp
                                <span>{{ optional($most_view)->min_read }}</span>
                                <span>&nbsp; · &nbsp;</span>
                                @php
                                    $new_format = optional($most_view)->created_at->format('d M Y');
                                @endphp
                                <span>{{ $new_format }},</span>
                                <span class="ms-2"><a href="{{ route('article.detail', optional($most_view)->slug) }}">
                                        <i
                                            class="fa-regular fa-eye"></i></a>&nbsp;{{ $views['screenPageViews'] ?? '0' }}&nbsp;Views</span>

                            </div>

                            <div class="article-description">{!! optional($most_view)->description ?? '' !!}</div>
                            <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                                @php
                                    $most_view->about = explode(',', optional($most_view)->about);
                                @endphp
                                @foreach ($most_view->about as $about)
                                    <span class="badge m-1">{{ $about }}</span>
                                @endforeach
                            </div>

                            <a href="{{ route('article.detail', optional($most_view)->slug) }}"
                                class="text-decoration-none d-flex justify-content-end">Read More....</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <span style="color: #a6adbb">No {{ $request->asc_desc_filter == 'desc' ? 'Most' : 'Least' }} Viewed Articles
                Found For
                {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} -
                {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</span>
        @endif

    @endif

    @if ($request->common_filter === App\Enums\CommonFilterType::Ratings->value)

        @if ($most_rated->isNotEmpty())
            <!----------------------Top Most Rated Articles---------------------->
            <div>
                <h4 class="mx-3">
                    {{ $request->pagination_filter == -1 ? 'All' : '' . $request->pagination_filter }}
                    {{ $request->asc_desc_filter == 'desc' ? 'Most' : 'Least' }} Rated Articles
                </h4>
                <div class="d-flex flex-wrap justify-content-center align-items-center">

                    @foreach ($most_rated as $most_rate)
                        <hr>
                        <div class="card  article-card col-11  col-sm-11 col-md-5 col-xxl-4 mb-3 mx-2 col-xxl-3">
                            <h6 class="card-title">{{ optional($most_rate)->name }}</h6>
                            <div class="d-flex mb-2">
                                <span style="color: #ffc700">
                                    @if (optional($most_rate)->reviews_avg_rating === 0)
                                        No review yet
                                    @else
                                        {!! str_repeat('<i class="fa-solid fa-star" ></i>', optional($most_rate)->reviews_avg_rating) !!}
                                    @endif
                                </span>

                            </div>
                            <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3">
                                @php
                                    optional($most_rate)->min_read = optional($most_rate)->min_read . ' min read';
                                @endphp
                                <span>{{ optional($most_rate)->min_read }}</span>
                                <span>&nbsp; · &nbsp;</span>
                                @php
                                    $new_format = optional($most_rate)->created_at->format('d M Y');
                                @endphp
                                <span>{{ $new_format }},</span>
                                <span class="ms-2"><a
                                        href="{{ route('article.detail', optional($most_rate)->slug) }}"><i
                                            class="fa-regular fa-eye"></i></a>&nbsp;{{ $views['screenPageViews'] ?? '0' }}&nbsp;Views</span>

                            </div>

                            <div class="article-description">{!! optional($most_rate)->description ?? '' !!}</div>
                            <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                                @php
                                    $most_rate->about = explode(',', optional($most_rate)->about);
                                @endphp
                                @foreach ($most_rate->about as $about)
                                    <span class="badge m-1">{{ $about }}</span>
                                @endforeach
                            </div>

                            <a href="{{ route('article.detail', optional($most_rate)->slug) }}"
                                class="text-decoration-none d-flex justify-content-end">Read More....</a>

                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <span style="color: #a6adbb">No {{ $request->asc_desc_filter == 'desc' ? 'Most' : 'Least' }} Rated Articles
                Found For {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} -
                {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</span>
        @endif

    @endif
@endif
