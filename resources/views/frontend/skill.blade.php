<div class="relative py-20" id="skills">
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Skills</h4>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($skills as $skill)
                <div class="group relative bg-card/40 backdrop-blur-md border border-white/5 rounded-2xl p-6 hover:-translate-y-2 hover:border-accent/50 transition-all duration-300 shadow-lg shadow-black/20 hover:shadow-accent/20 overflow-hidden">
                    
                    <!-- Icon/Image -->
                    <div class="flex justify-center mb-6 relative z-10">
                        <div class="w-20 h-20 bg-black/20 rounded-full flex items-center justify-center p-4 group-hover:scale-110 transition-transform duration-300">
                             <img src="{{ optional($skill)->image_path }}" alt="{{ optional($skill)->name }}" class="w-full h-full object-contain" />
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="text-center relative z-10">
                        <h6 class="text-heading font-bold text-lg mb-3 tracking-wide">{{ optional($skill)->name }}</h6>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-black/30 rounded-full h-2 mb-2 overflow-hidden">
                             <div class="bg-accent h-full rounded-full transition-all duration-1000 ease-out w-0 group-hover:w-[var(--percent)]" style="--percent: {{ optional($skill)->percentage }}%"></div>
                        </div>
                        <span class="text-xs font-mono text-body/70">{{ optional($skill)->percentage }}% Proficiency</span>
                    </div>

                    <!-- Decorative Glow -->
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-accent/20 blur-3xl rounded-full group-hover:bg-accent/30 transition-colors"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('front_js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Trigger animations when in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bars = entry.target.querySelectorAll('.bg-accent');
                        bars.forEach(bar => {
                            bar.style.width = bar.style.getPropertyValue('--percent');
                        });
                    }
                });
            }, { threshold: 0.1 });

            const skillSection = document.getElementById('skills');
            if(skillSection) observer.observe(skillSection);
        });
    </script>
@endpush
