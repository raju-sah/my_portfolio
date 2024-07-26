<div class="container-fluid article">
    <br>
    <br>
    <h4 class="mx-5">Articles</h4>
    <hr>
    <div class="d-flex flex-wrap justify-content-center align-items-center">
        @foreach ($articles as $article)
            <div class="card  article-card col-11  col-sm-11 col-md-5 col-xxl-4 mb-3 mx-2 col-xxl-3">
                <h6 class="card-title">{{ $article->name }}</h6>
                <div class="d-flex mb-2">
                    <span style="color: #ffc700">
                        @if ($article->reviews_avg_rating === 0)
                            <span>No review yet</span>
                        @else
                            {!! str_repeat('<i class="fa-solid fa-star"></i>', $article->reviews_avg_rating) !!}
                        @endif
                    </span>
                </div>
                <div class="card-subtitle d-flex justify-content-start flex-wrap mb-3">
                    @php
                        $article->min_read = $article->min_read . ' min read';
                    @endphp
                    <span>{{ $article->min_read }}</span>
                    <span>&nbsp; · &nbsp;</span>
                    @php
                        $new_format = $article->created_at->format('d M Y');
                    @endphp
                    <span>{{ $new_format }},</span>
                    <span class="ms-2"><a href="{{ route('article.detail', $article->slug) }}"><i
                                class="fa-regular fa-eye"></i></a>&nbsp;{{ $article->views }}&nbsp;Views</span>
                </div>

                <div class="article-description">{!! $article->description ?? '' !!}</div>
                <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                    @php
                        $article->about = explode(',', $article->about);
                    @endphp
                    @foreach ($article->about as $about)
                        <span class="badge m-1">{{ $about }}</span>
                    @endforeach
                </div>

                <a href="{{ route('article.detail', $article->slug) }}"
                    class="text-decoration-none d-flex justify-content-end">Read More....</a>

            </div>
        @endforeach
    </div>
    <div class=" mt-5">
        <a href="{{ route('articles.all') }}" class="text-decoration-none more d-flex justify-content-start mx-5 px-5"
            style="position: relative; left: 74px;">
            <i class="fa-solid fa-angle-up" style="color: #cf3f36"></i>
            <span class="more-projects">More Articles....</span>
        </a>
    </div>
</div>
