<section class="scroll-section relative py-20" id="speciality"
    data-bg="rgb(30, 50, 40)" data-text="rgb(210, 230, 215)"
    data-bg-light="rgb(210, 230, 215)" data-text-light="rgb(30, 50, 40)">
    <div class="scroll-reveal-text">Projects</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-10 border-b border-heading/20 pb-4 inline-block">Projects</h4>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach ($projects as $key => $project)
            <div class="group relative flex flex-col bg-white/5 backdrop-blur-sm p-8 rounded-2xl transition-all duration-300 border border-white/5 hover:border-white/10 hover:shadow-2xl hover:shadow-accent/5 h-full">
                <!-- Header: Year, Image, Name, GitHub -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex gap-4">
                        <img src="{{ optional($project)->image_path }}" alt="{{ optional($project)->name }}" class="w-14 h-14 object-cover rounded-xl shadow-lg border border-white/10" />
                        <div>
                            <span class="text-[10px] font-mono text-body/40 uppercase tracking-[0.2em] block mb-1">{{ optional($project)->year }}</span>
                            <a href="{{ optional($project)->web_url }}" target="_blank" class="flex items-center gap-2 group/title text-heading font-bold text-xl hover:text-accent transition-all">
                                <span>{{ optional($project)->name }}</span>
                                <svg class="w-4 h-4 shrink-0 text-accent/60 group-hover/title:translate-x-1 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <a href="{{ optional($project)->github_url }}" target="_blank" class="text-body/50 hover:text-heading transition-colors p-2 hover:bg-white/5 rounded-lg">
                        <i class="fa-brands fa-github text-2xl"></i>
                    </a>
                </div>

                <!-- Description -->
                <div class="text-body mb-8 leading-relaxed rich-content text-sm flex-grow">
                    {!! optional($project)->description !!}
                </div>

                <!-- Tech Stack -->
                <div class="flex flex-wrap gap-2 pt-6 border-t border-white/5">
                    @php
                    $techs = json_decode(optional($project)->tech_used);
                    @endphp
                    @if ($techs)
                    @foreach ($techs as $tech)
                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-accent bg-accent/10 rounded-full border border-accent/20 transition-colors hover:bg-accent/20">
                        {{ $tech }}
                    </span>
                    @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('projects.all') }}" class="inline-flex items-center gap-2 text-accent hover:text-heading transition-colors font-medium">
                <i class="fa-solid fa-angle-up"></i>
                <span class="text-lg">View Full Project Archive</span>
            </a>
        </div>
    </div>
</section>