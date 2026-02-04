<div class="scroll-section relative py-20" id="skills" 
     data-bg="rgb(30, 41, 59)" data-text="rgb(203, 213, 225)"
     data-bg-light="rgb(215, 225, 235)" data-text-light="rgb(30, 45, 65)">
    <div class="scroll-reveal-text">Skills</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Skills</h4>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($skills as $skill)
                <div class="group relative bg-white/5 backdrop-blur-sm p-6 rounded-2xl transition-all duration-300 border border-white/5 hover:border-white/10 hover:bg-white/[0.08] flex flex-col items-center text-center">
                    
                    <!-- Icon -->
                    <div class="mb-5">
                        <div class="w-16 h-16 bg-black/20 rounded-2xl flex items-center justify-center p-3 group-hover:scale-110 transition-transform duration-300">
                             <img src="{{ optional($skill)->image_path }}" alt="{{ optional($skill)->name }}" class="w-full h-full object-contain" />
                        </div>
                    </div>
    
                    <!-- Name & Info -->
                    <div class="mb-6 w-full">
                        <h6 class="text-heading font-bold text-lg tracking-wide mb-1">{{ optional($skill)->name }}</h6>
                        <span class="text-xs font-mono text-body/40 uppercase tracking-widest">Proficiency</span>
                    </div>

                    <!-- Progress Bar (Circular or slim at bottom) -->
                    <div class="w-full mt-auto">
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-center px-1">
                                <span class="text-xs font-mono text-accent">{{ optional($skill)->percentage }}%</span>
                            </div>
                            <div class="w-full bg-black/30 rounded-full h-1.5 overflow-hidden">
                                 <div class="bg-accent h-full rounded-full transition-all duration-1000 ease-out w-0 group-hover:w-[var(--percent)]" style="--percent: {{ optional($skill)->percentage }}%"></div>
                            </div>
                        </div>
                    </div>

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
