@extends('layouts.front_master')
@section('title', $article->name)
@section('content')

    <div class="scroll-section relative py-20 transition-all duration-300"
        data-bg="rgb(45, 30, 60)" data-text="rgb(230, 210, 245)"
        data-bg-light="rgb(235, 220, 240)" data-text-light="rgb(45, 30, 65)">
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h1 class="text-4xl md:text-5xl font-bold text-heading mb-4 tracking-tight leading-tight">
                        {{ $article->name }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-center text-xs text-body/60 gap-4 font-mono uppercase tracking-[0.2em]">
                        <span class="flex items-center gap-1"><i class="fa-regular fa-calendar-alt text-accent"></i> {{ $article->created_at->format('d M Y') }}</span>
                        <span class="w-1.5 h-1.5 bg-accent/30 rounded-full hidden md:block"></span>
                        <span class="flex items-center gap-1"><i class="fa-regular fa-clock text-accent"></i> {{ $article->min_read }} min read</span>
                        <span class="w-1.5 h-1.5 bg-accent/30 rounded-full hidden md:block"></span>
                        <span class="flex items-center gap-1 px-2 py-1 rounded-md ">
                            <i class="fa-regular fa-eye text-accent"></i> {{ $views['screenPageViews'] ?? '0' }} Views
                        </span>
                    </div>

                    <div class="flex items-center justify-center mt-2 text-yellow-500 gap-1">
                        @if ($article->reviews_avg_rating === 0)
                            <span class="text-body/40 italic text-sm">No reviews yet</span>
                        @else
                            @for ($i = 0; $i < $article->reviews_avg_rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        @endif
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="mb-12 rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-white/10 group">
                    <img src="{{ $article->image_path }}" alt="{{ $article->name }}" 
                         style="height: 400px !important;"
                         class="w-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>

                <!-- Content -->
                <article class="prose prose-invert prose-lg max-w-none text-body/70 leading-[1.8] mb-12 article-content">
                    {!! $article->description !!}
                </article>

                <!-- Tags -->
                <div class="flex flex-wrap gap-3 py-3 mb-12">
                    @php
                        $tags = is_string($article->about) ? explode(',', $article->about) : $article->about;
                    @endphp
                    @foreach ($tags as $tag)
                        <span class="px-5 py-2 text-xs uppercase font-bold tracking-[0.15em] text-accent border border-accent/20 rounded-full bg-accent/5 backdrop-blur-md">
                            {{ trim($tag) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
        <div class="container mx-auto px-6 max-w-4xl pb-12">
            <h2 class="text-3xl font-bold text-heading mb-10 pb-4 border-b border-white/10">Community Reviews</h2>
            <div id="review_card" class="space-y-6 mb-16"></div>

            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-12 shadow-xl">
                <h3 class="text-2xl font-bold text-heading mb-8">Leave a Review</h3>
                <x-form.wrapper action="" method="POST" id="rating_form" class="space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center gap-6 mb-8">
                        <span class="text-body/60 font-medium">Your Rating:</span>
                        <div class="star-rating">
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
                    </div>

                    <input type="text" id="pri_min" name="pri_min" style="opacity: 0; height: 0; position: absolute;" value="">
                    <input type="hidden" name="article_id" value="{{ $article->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form.input type="text" :req="true" label="Name" id="name" name="name" placeholder="John Doe"
                            value="{{ old('name') }}" class="modern-input" />
                        <x-form.input type="text" :req="true" label="Email" id="email" name="email" placeholder="john@example.com"
                            value="{{ old('email') }}" class="modern-input" />
                    </div>

                    <x-form.textarea label="Comment" :req="true" id="description" name="description" placeholder="Share your thoughts on this article..."
                        value="{{ old('description') }}" rows="4" class="modern-input" />

                    <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-6">
                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        <button type="submit" class="group relative px-3 py-2 bg-accent hover:bg-white text-white hover:text-accent font-bold rounded-2xl transition-all duration-300 flex items-center gap-1 overflow-hidden btn_submit">
                            <span class="relative z-10">Submit Review</span>
                            <i class="fa-solid fa-paper-plane relative z-10 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        </button>
                    </div>
                </x-form.wrapper>
            </div>
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

                const initials = review.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                let row = `
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-2 transition-all duration-300 hover:border-accent/30 shadow-lg" id="review_card_${review.id}">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-accent/10 border border-accent/20 flex items-center justify-center text-accent font-bold text-xs">
                                    ${initials}
                                </div>
                                <div>
                                    <h4 class="text-heading font-bold text-sm mb-0.5">${review.name}</h4>
                                    <p class="text-body/40 text-[10px] font-mono uppercase tracking-wider">${formattedDate}</p>
                                </div>
                            </div>
                            <div class="flex text-yellow-500 text-[10px] bg-yellow-500/5 px-2.5 py-1 rounded-full">
                                ${ratingHtml}
                            </div>
                        </div>
                        <p class="text-body/70 leading-relaxed text-sm review_desc" id="review_${review.id}">${review.description}</p>
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
                            const initials = review.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                            let row = `
                            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-4 transition-all duration-300 hover:border-accent/30 shadow-lg" id="review_card_${review.id}">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 rounded-full bg-accent/10 border border-accent/20 flex items-center justify-center text-accent font-bold text-xs">
                                            ${initials}
                                        </div>
                                        <div>
                                            <h4 class="text-heading font-bold text-sm mb-0.5">${review.name}</h4>
                                            <p class="text-body/40 text-[10px] font-mono uppercase tracking-wider">${formattedDate}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-500 text-[10px] bg-yellow-500/5 px-2.5 py-1 rounded-full">
                                        ${ratingHtml}
                                    </div>
                                </div>
                                <p class="text-body/70 leading-relaxed text-sm review_desc" id="review_${review.id}">${review.description}</p>
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
