<div class="scroll-section relative py-20" id="skills" 
     data-bg="rgb(30, 41, 59)" data-text="rgb(203, 213, 225)"
     data-bg-light="rgb(215, 225, 235)" data-text-light="rgb(30, 45, 65)">
    <div class="scroll-reveal-text">Skills</div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
            <div>
                <h4 class="text-4xl font-bold text-heading mb-2">My Expertise</h4>
                <p class="text-body max-w-lg">I've spent years honing my skills across various domains, specializing in building robust and scalable digital solutions.</p>
            </div>
            <div class="h-px bg-heading/10 flex-grow md:mx-12 hidden md:block"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-20 gap-y-16">
            @foreach ($skills as $domainId => $domainSkills)
                <div class="skill-group transform transition-all duration-700 translate-y-8 opacity-0" data-animate="true">
                    <div class="flex items-center gap-4 mb-10">
                        <span class="text-accent font-mono text-sm tracking-widest px-3 py-1 bg-accent/10 rounded-full">0{{ $loop->iteration }}</span>
                        <h5 class="text-xl font-bold text-heading tracking-wider uppercase">
                            {{ $domainId ? \App\Enums\SkillDomain::from($domainId)->label() : 'Other Skills' }}
                        </h5>
                    </div>

                    <div class="flex flex-col gap-10">
                        @foreach ($domainSkills as $skill)
                            <div class="skill-item group" data-percent="{{ $skill->percentage }}">
                                <div class="flex justify-between items-end mb-3">
                                    <div class="flex flex-col">
                                        <h6 class="text-heading font-bold text-lg transition-all duration-300 group-hover:translate-x-1 group-hover:text-accent">
                                            {{ $skill->name }}
                                        </h6>
                                        @if($skill->description)
                                            <span class="text-xs text-body/60 mt-0.5">{{ $skill->description }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-baseline gap-0.5">
                                        <span class="skill-number text-accent font-mono text-2xl font-black">0</span>
                                        <span class="text-accent font-mono text-sm font-bold">%</span>
                                    </div>
                                </div>
                                
                                <div class="relative h-2 w-full bg-black/20 rounded-full overflow-hidden border border-white/5">
                                    <div class="skill-bar absolute top-0 left-0 h-full bg-accent rounded-full transition-all duration-1000 ease-[cubic-bezier(0.34,1.56,0.64,1)] shadow-[0_0_12px_rgba(var(--accent-rgb),0.5)]" 
                                         style="width: 0%">
                                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full shadow-lg scale-0 group-hover:scale-125 transition-transform duration-300"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('front_js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const skillGroups = document.querySelectorAll('[data-animate="true"]');
            
            const animateSkill = (item) => {
                const bar = item.querySelector('.skill-bar');
                const number = item.querySelector('.skill-number');
                const percent = parseInt(item.getAttribute('data-percent'));
                
                // Animate Bar
                bar.style.width = percent + '%';
                
                // Animate Number (Smooth ease-out count up)
                let currentPos = 0;
                const duration = 2000;
                const startTime = performance.now();
                
                const easeOutExpo = (t) => t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
                
                const updateNumber = (now) => {
                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const currentPercent = Math.floor(easeOutExpo(progress) * percent);
                    
                    number.textContent = currentPercent;
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateNumber);
                    }
                };
                
                requestAnimationFrame(updateNumber);
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Animate group entry
                        entry.target.classList.remove('translate-y-8', 'opacity-0');
                        entry.target.classList.add('translate-y-0', 'opacity-100');
                        
                        // Animate individual skills inside
                        const items = entry.target.querySelectorAll('.skill-item');
                        items.forEach((item, index) => {
                            setTimeout(() => {
                                animateSkill(item);
                            }, index * 150 + 200);
                        });
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });

            skillGroups.forEach(group => observer.observe(group));
        });
    </script>
@endpush
