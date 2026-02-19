<section class="scroll-section relative py-20 transition-all duration-300"
    data-bg="rgb(55, 40, 25)" data-text="rgb(245, 225, 205)"
    data-bg-light="rgb(245, 225, 205)" data-text-light="rgb(55, 40, 25)">
    <div class="scroll-reveal-text">Experience</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-10 border-b border-heading/20 pb-4 inline-block">Experiences</h4>

        <div class="hidden md:grid grid-cols-12 gap-8 mb-8 text-sm font-medium text-body/50 uppercase tracking-wider">
            <div class="col-span-3">Designation / Role</div>
            <div class="col-span-9 pl-4">Company & Description</div>
        </div>

        <div class="space-y-12">
            @foreach ($experiences as $key => $experience)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 group">
                <!-- Designation Info -->
                <div class="md:col-span-3">
                    <h5 class="text-heading font-semibold text-lg mb-1 group-hover:text-accent transition-colors">{{ optional($experience)->role }}</h5>
                    <p class="text-sm font-mono text-body/70">
                        {{ optional($experience)->date_from }} — {{ optional($experience)->curently_here ? 'Present' : optional($experience)->date_to }}
                    </p>
                </div>

                <!-- Company Info -->
                <div class="md:col-span-9 md:border-l md:border-white/10 md:pl-8 relative">
                    <!-- Timeline Dot -->
                    <span class="hidden md:block absolute -left-[5px] top-2 w-2.5 h-2.5 rounded-full bg-accent ring-4 ring-bg-primary"></span>

                    <a href="{{ optional($experience)->web_url }}" target="_blank" class="flex items-center gap-3 mb-4 group/link no-underline text-decoration-none">
                        <img src="{{ optional($experience)->image_path }}" alt="{{ optional($experience)->name }}" class="w-8 h-8 rounded object-cover" />
                        <h6 class="text-xl font-bold text-heading transition-colors">{{ optional($experience)->name }}</h6>
                        <svg class="w-4 h-4 text-body opacity-0 group-hover/link:opacity-100 transition-all -translate-x-2 group-hover/link:translate-x-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    <div class="text-body leading-relaxed max-w-3xl">
                        {!! optional($experience)->description !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>