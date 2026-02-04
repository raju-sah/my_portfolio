<section class="scroll-section relative py-20" id="speciality"
    data-bg="rgb(30, 50, 40)" data-text="rgb(210, 230, 215)"
    data-bg-light="rgb(210, 230, 215)" data-text-light="rgb(30, 50, 40)">
    <div class="scroll-reveal-text">Projects</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-10 border-b border-heading/20 pb-4 inline-block">Projects</h4>

        <div class="space-y-12">
            @foreach ($projects as $key => $project)
            <div class="group relative grid grid-cols-1 md:grid-cols-12 gap-8 items-start hover:bg-white/5 backdrop-blur-sm p-6 rounded-2xl transition-all duration-300 border border-transparent hover:border-white/10">
                <!-- Year -->
                <div class="md:col-span-3">
                    <span class="text-sm font-mono text-body/60 uppercase tracking-widest">{{ optional($project)->year }}</span>
                </div>

                <!-- Content -->
                <div class="md:col-span-9">
                    <div class="flex items-center justify-between mb-4">
                        <a href="{{ optional($project)->web_url }}" target="_blank" class="flex items-center gap-4 group/title text-heading font-bold text-xl hover:text-accent transition-colors">
                            <img src="{{ optional($project)->image_path }}" alt="{{ optional($project)->name }}" class="w-10 h-10 object-cover rounded-lg shadow-sm" />
                            <span>{{ optional($project)->name }}</span>
                            <svg class="w-5 h-5 transition-transform group-hover/title:-translate-y-1 group-hover/title:translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>

                        <a href="{{ optional($project)->github_url }}" target="_blank" class="text-body hover:text-heading transition-colors">
                            <i class="fa-brands fa-github text-2xl"></i>
                        </a>
                    </div>

                    <div class="text-body mb-6 leading-relaxed">
                        {!! optional($project)->description !!}
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @php
                        $techs = json_decode(optional($project)->tech_used);
                        @endphp
                        @if ($techs)
                        @foreach ($techs as $key => $tech)
                        <span class="px-3 py-1 text-xs font-medium text-accent bg-accent/10 rounded-full border border-accent/20">
                            {{ $tech }}
                        </span>
                        @endforeach
                        @endif
                    </div>
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