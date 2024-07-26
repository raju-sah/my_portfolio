@extends('layouts.front_master')
@section('title', $article->name)
@section('content')

    <div class="continaer-fluid article-single ">
        <br>
        <br>
        <br>
        <div class=" px-5 mx-5 mb-5">
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
                            class="fa-regular fa-eye"></i></a>&nbsp;{{ $views['screenPageViews']?? '0' }}&nbsp;Views</span>
            </div>

            <div style="color: #747884">{!! $article->description ?? '' !!}</div>
            <div class="mb-3 mt-4 d-flex justify-content-start flex-wrap">
                @php
                    $article->about = explode(',', $article->about);
                @endphp
                @foreach ($article->about as $about)
                    <span class="badge m-1">{{ $about }}</span>
                @endforeach
            </div>

        </div>
        <h1 class="a-title d-flex justify-content-start mx-5 px-5 mt-5 mb-4">Reviews</h1>
        <div id="review_card"></div>

        <x-form.wrapper action="" method="POST" id="rating_form" class="mx-5 px-5">

            <div class="star-rating mt-5 mb-3">
                <input type="radio" id="5-stars" name="rating" value="5" checked />
                <label for="5-stars" class="star">&#9733;</label>
                <input type="radio" id="4-stars" name="rating" value="4" />
                <label for="4-stars" class="star">&#9733;</label>
                <input type="radio" id="3-stars" name="rating" value="3" />
                <label for="3-stars" class="star">&#9733;</label>
                <input type="radio" id="2-stars" name="rating" value="2" />
                <label for="2-stars" class="star">&#9733;</label>
                <input type="radio" id="1-star" name="rating" value="1" />
                <label for="1-star" class="star">&#9733;</label>
            </div>
            <input type="text" id="pri_min" name="pri_min" style="opacity: 0; height: 0" value="">
            <input type="hidden" name="article_id" value="{{ $article->id }}">

            <x-form.row>
                <x-form.input type="text" col="5" :req="true" label="Name" id="name" name="name"
                    value="{{ old('name') }}" />
                <x-form.input type="text" col="5" :req="true" label="email" id="email" name="email"
                    value="{{ old('email') }}" />
            </x-form.row>
            <x-form.textarea label="description" col="10" :req="true" id="description" name="description"
                value="{{ old('description') }}" rows="3" cols="3" />

            <div class="g-recaptcha mt-3 d-flex justify-content-center" style="max-width: 304px;" id="feedback-recaptcha"
                data-sitekey="{{ config('services.recaptcha.site_key') }}">
            </div>

            <div class="button-click mt-4 d-flex justify-content-start ">
                <button type="submit" class="title-btn btn_submit">
                    <span>Submit</span>
                </button>
            </div>
        </x-form.wrapper>
    </div>
    </div>
@endsection

@push('front_js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        let storeRoute = "{{ route('articles.rating.store') }}";
    </script>

    @include('_helpers.single_page_table_ajax', ['formId' => '#rating_form'])

    <script type="text/javascript">
        $(document).ready(function() {
            const form = $('#rating_form');

            let isEditing = false;
            let editingModelId;

            fetchItineraries();

            const btn_submit = $('.btn_submit');

            $('#rating_form').on('submit', function(e) {
                e.preventDefault();
                const pri_min = $('#pri_min').val();

                if (pri_min !== '') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Fake Content detected!',
                    }).then((result) => {
                        $('#rating_form')[0].reset();
                    });

                } else {
                    saveData();
                }
            });

            $(document).on('fetchEvent', function(event, response) {
                let review = response.review;
                let ratingHtml = '';
                if (review.rating === 0) {
                    ratingHtml = '<span>No review yet</span>';
                } else {
                    for (let i = 0; i < review.rating; i++) {
                        ratingHtml += '<i class="fa-solid fa-star"></i>';
                    }
                }
                const formattedDate = formatDate(review.created_at);

                let row = `
                    <div class="card mt-2 mx-5 py-3 px-5" id="review_card_${review.id}" style="background: #000; color: #747884; box-shadow: #8a2e2e82 4px 19px 151px;">
                        <div class="d-flex mb-2">
                            <span style="color: #ffc700">
                                ${ratingHtml}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap align-items-center row1" data-id="${review.id}">
                            <img src="https://www.freeiconspng.com/thumbs/person-icon/person-icon-8.png" height="40px" width="40px" alt="">
                            <div class="ms-1">
                                <span class="d-flex flex-start">${review.name}</span>
                                <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${review.email}</span>
                            </div>
                            <div class="ms-auto">${formattedDate}</div>
                        </div>
                        <p class="d-flex mt-2 review_desc" id="review_${review.id}">${review.description}</p>
                    </div>
                    `;

                $('#review_card').prepend(row);

                $('html, body').animate({
                    scrollTop: $("#review_card_" + review.id).offset().top - 180
                }, 'fast');
            });

            // $(document).on('click', '.btn_submit', function() {
            //     $('html, body').animate({
            //         // scrollTop: '-=100px' // Scroll up by 100 pixels
            //         scrollTop: $('#rating_form').offset().top - 60
            //     }, 'fast');
            // });

            function getOrdinalSuffix(day) {
                if (day > 3 && day < 21) return 'th';
                switch (day % 10) {
                    case 1:
                        return 'st';
                    case 2:
                        return 'nd';
                    case 3:
                        return 'rd';
                    default:
                        return 'th';
                }
            }

            function formatDate(date) {
                const d = new Date(date);
                const day = d.getDate();
                const month = d.toLocaleString('default', {
                    month: 'short'
                });
                const year = d.getFullYear();
                const ordinalSuffix = getOrdinalSuffix(day);
                return `${day}${ordinalSuffix} ${month} ${year}`;
            }

            function fetchItineraries() {
                $.ajax({
                    url: "{{ route('articles.rating.index', $article->id) }}",
                    type: 'GET',
                    success: function(response) {
                        let tableBody = $('#review_card');
                        tableBody.empty();

                        $.each(response.reviews, function(index, review) {
                            let ratingHtml = '';
                            if (review.rating === 0) {
                                ratingHtml = '<span>No review yet</span>';
                            } else {
                                for (let i = 0; i < review.rating; i++) {
                                    ratingHtml += '<i class="fa-solid fa-star"></i>';
                                }
                            }

                            const formattedDate = formatDate(review.created_at);

                            let row = `
                            <div class="card mt-2 mx-5 py-3 px-5" id="review_card" style="background: #000; color: #747884; box-shadow: #8a2e2e82 4px 19px 151px; border-radius: 10px;">
                                <div class="d-flex mb-2">
                                    <span style="color: #ffc700">
                                        ${ratingHtml}
                                    </span>
                                </div>
                                <div class="d-flex flex-wrap align-items-center row1" data-id="${review.id}">
                                    <img src="https://www.freeiconspng.com/thumbs/person-icon/person-icon-8.png" height="40px" width="40px" alt="">
                                    <div class="ms-1">
                                        <span class="d-flex flex-start">${review.name}</span>
                                        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${review.email}</span>
                                    </div>
                                    <div class="ms-auto">${formattedDate}</div>
                                </div>
                                <p class="d-flex mt-2 review_desc" id="review">${review.description}</p>
                            </div>
                            `;
                            tableBody.append(row);
                        });
                    }
                });
            }
            $(document).on('click', '.review_desc', function() {
                $(this).toggleClass('expanded');
            });
        });
    </script>
@endpush
