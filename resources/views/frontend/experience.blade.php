<section class="scroll-section relative py-20 transition-all duration-300 overflow-hidden"
    data-bg="rgb(55, 40, 25)" data-text="rgb(245, 225, 205)"
    data-bg-light="rgb(245, 225, 205)" data-text-light="rgb(55, 40, 25)">
    <div class="scroll-reveal-text">Experience</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-16 border-b border-heading/20 pb-4 inline-block">Experiences</h4>

        {{-- ===== 3D Road Journey Container ===== --}}
        <div class="road-container" id="roadContainer">
            {{-- Celestial Starfield Background --}}
            <canvas id="roadStars" class="road-stars-canvas"></canvas>

            {{-- Floating Tech Assets for Parallax Depth --}}
            <div class="road-floating-assets hidden md:block">
                <div class="road-asset" style="top: 15%; left: 10%;" data-speed="1.2">
                    <svg class="w-12 h-12 opacity-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99z" />
                    </svg>
                </div>
                <div class="road-asset" style="top: 45%; left: 85%;" data-speed="1.5">
                    <svg class="w-16 h-16 opacity-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8h16v10z" />
                    </svg>
                </div>
                <div class="road-asset" style="top: 75%; left: 15%;" data-speed="1.1">
                    <svg class="w-10 h-10 opacity-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                    </svg>
                </div>
            </div>

            {{-- SVG Road — generated dynamically by JS --}}
            <svg class="road-svg" id="roadSvg" aria-hidden="true">
                <defs>
                    {{-- Road glow filter --}}
                    <filter id="roadGlow" x="-50%" y="-50%" width="200%" height="200%">
                        <feGaussianBlur stdDeviation="4" result="blur" />
                        <feMerge>
                            <feMergeNode in="blur" />
                            <feMergeNode in="SourceGraphic" />
                        </feMerge>
                    </filter>
                    {{-- Traveler glow filter --}}
                    <filter id="travelerGlow" x="-300%" y="-300%" width="700%" height="700%">
                        <feGaussianBlur stdDeviation="6" result="blur" />
                        <feMerge>
                            <feMergeNode in="blur" />
                            <feMergeNode in="blur" />
                            <feMergeNode in="SourceGraphic" />
                        </feMerge>
                    </filter>
                    {{-- Pro-Modern Noise/Grain Filter --}}
                    <filter id="noiseFilter">
                        <feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch" />
                        <feColorMatrix type="saturate" values="0" />
                        <feComponentTransfer>
                            <feFuncR type="linear" slope="0.15" />
                            <feFuncG type="linear" slope="0.15" />
                            <feFuncB type="linear" slope="0.15" />
                        </feComponentTransfer>
                    </filter>
                </defs>

                {{-- Road body (wide, semi-transparent) --}}
                <path id="roadBody" class="road-body" fill="none" />
                {{-- Road glow edge --}}
                <path id="roadGlowPath" class="road-glow-edge" fill="none" filter="url(#roadGlow)" />
                {{-- Road center dashed line --}}
                <path id="roadCenter" class="road-center-line" fill="none" />
                {{-- Traveler trail (drawn portion with glow) --}}
                <path id="travelerTrail" class="traveler-trail" fill="none" filter="url(#roadGlow)" />

                {{-- Milestone markers rendered by JS --}}
                <g id="milestoneGroup"></g>

                {{-- Traveler dot --}}
                <circle id="travelerDot" class="traveler-dot" r="8" filter="url(#travelerGlow)" />
                <circle id="travelerCore" class="traveler-core" r="4" />
            </svg>

            {{-- ===== Experience Station Cards ===== --}}
            @foreach ($experiences as $key => $experience)
            <div class="road-station {{ $key % 2 === 0 ? 'road-left' : 'road-right' }}"
                data-station="{{ $key }}"
                id="station-{{ $key }}">

                {{-- Connector line to road --}}
                <div class="station-connector"></div>

                {{-- Station card --}}
                <div class="station-card">
                    {{-- Grain/Noise Overlay --}}
                    <div class="card-grain"></div>

                    {{-- Holographic Shimmer --}}
                    <div class="card-shimmer"></div>

                    {{-- Border Beam --}}
                    <div class="border-beam"></div>
                    
                    {{-- Milestone number badge --}}
                    <span class="station-number">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</span>

                    {{-- Company header --}}
                    <a href="{{ optional($experience)->web_url }}" target="_blank" class="station-company">
                        <img src="{{ optional($experience)->image_path }}" alt="{{ optional($experience)->name }}" class="station-logo" />
                        <div>
                            <h5 class="station-company-name">{{ optional($experience)->name }}</h5>
                            <span class="station-dates">
                                {{ optional($experience)->date_from }} — {{ optional($experience)->curently_here ? 'Present' : optional($experience)->date_to }}
                            </span>
                        </div>
                        <svg class="station-link-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    {{-- Role --}}
                    <h6 class="station-role">{{ optional($experience)->role }}</h6>

                    {{-- Description --}}
                    <div class="station-description">
                        {!! optional($experience)->description !!}
                    </div>

                    {{-- Tech Tags --}}
                    <div class="station-tech-tags">
                        @php
                            $tags = json_decode($experience->tags);
                        @endphp
                        @if ($tags)
                            @foreach ($tags as $tag)
                                <span class="tech-tag">{{ $tag }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Mobile fallback: simple vertical layout --}}
        </div>
    </div>
</section>