@push('front_css')
<style>
    .article-card-hover {
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .article-card-hover:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
    }
</style>
@endpush

{{-- ── Articles Section ── --}}
<div class="scroll-section relative py-20 transition-all duration-300"
    data-bg="rgb(45, 30, 60)" data-text="rgb(230, 210, 245)"
    data-bg-light="rgb(235, 220, 240)" data-text-light="rgb(45, 30, 65)">
    <div class="scroll-reveal-text">Articles</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Articles</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            @foreach ($articles as $article)
            <div class="article-card-hover group bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:border-accent/40 transition-all duration-300 flex flex-col h-full shadow-lg shadow-black/10 overflow-hidden">
                <!-- Image -->
                <a href="{{ route('article.detail', $article->slug) }}" class="relative h-40 mb-6 overflow-hidden rounded-xl block">
                    <img src="{{ $article->image_path }}" alt="{{ $article->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-medium px-2 py-1 bg-accent/80 rounded-lg backdrop-blur-sm">View Details</span>
                    </div>
                </a>

                <!-- Header -->
                <div class="flex justify-between items-start mb-2">
                    <h6 class="text-xl font-bold text-heading group-hover:text-accent transition-colors line-clamp-2">{{ $article->name }}</h6>
                </div>

                <!-- Meta -->
                <div class="flex items-center text-[10px] text-body/60 mb-3 gap-3 font-mono uppercase tracking-wider">
                    <span class="flex items-center gap-1"><i class="fa-regular fa-calendar-alt text-accent/60"></i> {{ $article->created_at->format('d M Y') }}</span>
                    <span class="w-1 h-1 bg-accent/30 rounded-full"></span>
                    <span class="flex items-center gap-1"><i class="fa-regular fa-clock text-accent/60"></i> {{ $article->min_read }} min read</span>
                    <a href="{{ route('article.detail', $article->slug) }}" class="ml-auto flex items-center gap-1 px-2 py-0.5 hover:text-accent transition-colors text-decoration-none">
                        <i class="fa-regular fa-eye text-accent text-decoration-none"></i> {{ $article->views }}
                    </a>
                </div>
                 <!-- Stars -->
                <div class="flex items-center gap-1 text-yellow-500 text-xs mb-4">
                    @if ($article->reviews_avg_rating === 0)
                    <span class="text-body/40 italic">No reviews</span>
                    @else
                    @for ($i = 0; $i < $article->reviews_avg_rating; $i++)
                        <i class="fa-solid fa-star"></i>
                        @endfor
                        @endif
                </div>

                <!-- Description -->
                <div class="text-sm text-body/70 line-clamp-2 mb-4 leading-relaxed">
                    {!! strip_tags($article->description) !!}
                </div>

                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mt-auto">
                    @php
                    $tags = explode(',', $article->about);
                    @endphp
                    @foreach ($tags as $tag)
                    <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest text-accent border border-accent/20 rounded-full bg-accent/5 backdrop-blur-sm">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('articles.all') }}?tab=article" class="inline-flex items-center gap-2 text-accent hover:text-heading transition-colors font-medium">
                <i class="fa-solid fa-angle-up"></i>
                <span class="text-lg">View All Articles</span>
            </a>
        </div>
    </div>
</div>

{{-- ── Stories Section ── --}}
@if ($stories->isNotEmpty())
<div class="scroll-section relative py-20 transition-all duration-300"
    data-bg="rgb(60, 20, 45)" data-text="rgb(255, 210, 225)"
    data-bg-light="rgb(255, 235, 240)" data-text-light="rgb(60, 20, 50)">
    <div class="scroll-reveal-text">Stories</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Stories</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            @foreach ($stories as $story)
            <div class="article-card-hover group bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:border-accent/40 transition-all duration-300 flex flex-col h-full shadow-lg shadow-black/10 overflow-hidden">
                <!-- Image -->
                <a href="{{ route('article.detail', $story->slug) }}" class="relative h-40 mb-6 overflow-hidden rounded-xl block">
                    <img src="{{ $story->image_path }}" alt="{{ $story->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-medium px-2 py-1 bg-accent/80 rounded-lg backdrop-blur-sm">Read Story</span>
                    </div>
                </a>

                <!-- Header -->
                <div class="flex justify-between items-start mb-2">
                    <h6 class="text-xl font-bold text-heading group-hover:text-accent transition-colors line-clamp-2">{{ $story->name }}</h6>
                    <!-- <span class="ml-2 px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest text-emerald-400 border border-emerald-400/30 rounded-full bg-emerald-400/5 whitespace-nowrap">Story</span> -->
                </div>

                <!-- Meta -->
                <div class="flex items-center text-[10px] text-body/60 mb-3 gap-3 font-mono uppercase tracking-wider">
                    <span class="flex items-center gap-1"><i class="fa-regular fa-calendar-alt text-accent/60"></i> {{ $story->created_at->format('d M Y') }}</span>
                    <span class="w-1 h-1 bg-accent/30 rounded-full"></span>
                    <span class="flex items-center gap-1"><i class="fa-regular fa-clock text-accent/60"></i> {{ $story->min_read }} min read</span>
                    <a href="{{ route('article.detail', $story->slug) }}" class="ml-auto flex items-center gap-1 px-2 py-0.5 hover:text-accent transition-colors text-decoration-none">
                        <i class="fa-regular fa-eye text-accent text-decoration-none"></i> {{ $story->views }}
                    </a>
                </div>

                <!-- Stars -->
                <div class="flex items-center gap-1 text-yellow-500 text-xs mb-4">
                    @if ($story->reviews_avg_rating === 0)
                    <span class="text-body/40 italic">No reviews</span>
                    @else
                    @for ($i = 0; $i < $story->reviews_avg_rating; $i++)
                        <i class="fa-solid fa-star"></i>
                    @endfor
                    @endif
                </div>

                <!-- Description -->
                <div class="text-sm text-body/70 line-clamp-2 mb-4 leading-relaxed">
                    {!! strip_tags($story->description) !!}
                </div>

                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mt-auto">
                    @php $tags = explode(',', $story->about); @endphp
                    @foreach ($tags as $tag)
                    <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest text-accent border border-accent/20 rounded-full bg-accent/5 backdrop-blur-sm">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('articles.all') }}?tab=story" class="inline-flex items-center gap-2 text-accent hover:text-heading transition-colors font-medium">
                <i class="fa-solid fa-angle-up"></i>
                <span class="text-lg">View All Stories</span>
            </a>
        </div>
    </div>
</div>
@endif