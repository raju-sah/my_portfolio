<div class="scroll-section relative py-20 bg-card/10 backdrop-blur-[2px]"
    data-bg="rgb(45, 30, 60)" data-text="rgb(230, 210, 245)"
    data-bg-light="rgb(235, 220, 240)" data-text-light="rgb(45, 30, 65)">
    <div class="scroll-reveal-text">Articles</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Articles</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($articles as $article)
            <div class="group bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:border-accent/40 transition-all duration-300 flex flex-col h-full shadow-lg shadow-black/10">
                <!-- Header -->
                <div class="flex justify-between items-start mb-4">
                    <h6 class="text-xl font-bold text-heading group-hover:text-accent transition-colors line-clamp-2">{{ $article->name }}</h6>
                </div>

                <!-- Meta -->
                <div class="flex items-center text-xs text-body/60 mb-4 gap-3 font-mono">
                    <span>{{ $article->min_read }} min read</span>
                    <span class="w-1 h-1 bg-accent rounded-full"></span>
                    <span>{{ $article->created_at->format('d M Y') }}</span>
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
                        <span class="ml-auto text-body/50 flex items-center gap-1">
                            <i class="fa-regular fa-eye"></i> {{ $article->views }}
                        </span>
                </div>

                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                    @php
                    $tags = explode(',', $article->about);
                    @endphp
                    @foreach ($tags as $tag)
                    <span class="px-2 py-1 text-[10px] uppercase font-bold tracking-wider text-accent border border-accent/20 rounded bg-accent/5">{{ $tag }}</span>
                    @endforeach
                </div>

                <!-- Link -->
                <a href="{{ route('article.detail', $article->slug) }}" class="inline-flex items-center justify-between w-full p-3 rounded-xl bg-black/20 hover:bg-accent text-body hover:text-white transition-all duration-300 font-medium text-sm group/btn">
                    <span>Read Article</span>
                    <i class="fa-solid fa-arrow-right -translate-x-2 opacity-0 group-hover/btn:translate-x-0 group-hover/btn:opacity-100 transition-all"></i>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('articles.all') }}" class="inline-flex items-center gap-2 text-accent hover:text-heading transition-colors font-medium">
                <i class="fa-solid fa-angle-up"></i>
                <span class="text-lg">View All Articles</span>
            </a>
        </div>
    </div>
</div>