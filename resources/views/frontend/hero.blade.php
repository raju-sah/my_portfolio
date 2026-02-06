    <style>
        .counter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .counter-container {

            i,
            span {
                font-size: clamp(0.5em, 1vw + 0.8em, 3em);
            }

            #views,
            #counter {
                font-size: clamp(1em, 2vw + 1em, 3em);
                color: #cf3f36;
            }

        }
    </style>

    <section class="scroll-section relative min-h-[calc(100vh-80px)] flex items-center justify-center overflow-hidden"
        data-bg="rgb(26, 26, 26)" data-text="rgb(240, 240, 240)"
        data-bg-light="rgb(245, 245, 245)" data-text-light="rgb(30, 30, 30)">
        <div class="scroll-reveal-text">Portfolio</div>
        <div class="container mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <!-- Content Left -->
            <div class="text-center lg:text-left py-4 md:py-0">
                <span class="block text-base md:text-xl text-accent font-medium tracking-widest mb-2 md:mb-1 uppercase">Hello I'm</span>
                @include('frontend.sandAnimation.sandAnimation')

                <h1 class="text-3xl md:text-4xl font-black text-heading mb-3 md:mb-2 leading-tight">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-heading to-body">A</span>
                    <span class="multiText text-accent"></span>
                </h1>

                <p class="text-body text-base md:text-lg font-light max-w-lg mx-auto lg:mx-0 mb-3 leading-relaxed">
                    {!! optional($home_setting)->description !!}
                </p>

                <p class="text-body/60 text-xs mb-4 font-mono">
                    // I am usually occupied, but open to new opportunities. <br class="hidden md:block"> Hit me on Linkedin for chat.
                </p>

                <!-- Stats -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <div class="stat-card-tooltip flex items-center gap-4 bg-card/40 border border-card p-3 rounded-2xl backdrop-blur-sm shadow-theme cursor-pointer" data-tooltip="�️ 55% Moltys, 30% bots, 10% SEO goblins, 4% my refresh button, 1% confused human">
                        <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent">
                            <i class="fa-regular fa-eye text-xl"></i>
                        </div>
                        <div class="text-left">
                            <span class="block text-2xl font-bold text-heading" id="views">0</span>
                            <span class="text-xs text-body/60 uppercase tracking-wider">Views</span>
                        </div>
                    </div>

                    <div class="stat-card-tooltip flex items-center gap-4 bg-card/40 border border-card p-3 rounded-2xl backdrop-blur-sm shadow-theme cursor-pointer" data-tooltip="� Moltys, Moltbots, crawlers & one human who misclicked">
                        <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                        <div class="text-left">
                            <span class="block text-2xl font-bold text-heading" id="counter">0</span>
                            <span class="text-xs text-body/60 uppercase tracking-wider">Visitors</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Interactive SVG Illustration Right -->
            <div class="relative hidden lg:block max-h-[400px] w-full aspect-square my-auto" id="hero-svg-container">
                <svg id="hero-interactive-svg" viewBox="0 0 500 500" class="w-full h-auto drop-shadow-2xl" style="cursor: default;">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#cf3f36;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#f44336;stop-opacity:0.8" />
                        </linearGradient>
                        <radialGradient id="ballGrad" cx="30%" cy="30%" r="70%">
                            <stop offset="0%" style="stop-color:#ff6b5b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#cf3f36;stop-opacity:1" />
                        </radialGradient>
                        <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                            <feDropShadow dx="0" dy="10" stdDeviation="15" flood-color="rgba(207,63,54,0.4)" />
                        </filter>
                        <filter id="iconShadow" x="-50%" y="-50%" width="200%" height="200%">
                            <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="rgba(0,0,0,0.3)" />
                        </filter>
                    </defs>

                    <!-- Outer Orbit (Red Dashed) - Rotating -->
                    <circle id="orbit-outer" cx="250" cy="250" r="200" stroke="url(#grad1)" stroke-width="1.5" fill="none" stroke-dasharray="8 6" class="opacity-40 orbit-ring" style="transform-origin: 250px 250px;" />

                    <!-- Middle Orbit (Gray Dashed) - Rotating opposite -->
                    <circle id="orbit-middle" cx="250" cy="250" r="150" stroke="var(--text-heading)" stroke-width="1" fill="none" stroke-dasharray="5 5" class="opacity-20 orbit-ring" style="transform-origin: 250px 250px;" />

                    <!-- Inner Orbit - Rotating -->
                    <circle id="orbit-inner" cx="250" cy="250" r="100" stroke="var(--text-body)" stroke-width="0.5" fill="none" stroke-dasharray="3 4" class="opacity-15 orbit-ring" style="transform-origin: 250px 250px;" />

                    <!-- Floating Code Icon - Orbits on inner circle -->
                    <g id="icon-code" class="floating-icon draggable-element" data-tooltip="The messy code I vibe-coded. It runs on caffeine and poor life choices." data-orbit-radius="100" data-orbit-offset="0" data-rest-x="250" data-rest-y="150" style="cursor: grab;" filter="url(#iconShadow)">
                        <circle r="18" fill="rgba(40,40,40,0.95)" stroke="rgba(255,255,255,0.15)" stroke-width="1" />
                        <text x="-6" y="5" fill="var(--text-body)" font-size="11" font-family="monospace" pointer-events="none">&lt;/&gt;</text>
                    </g>

                    <!-- Floating X Icon - Orbits on inner circle (opposite side) -->
                    <g id="icon-close" class="floating-icon draggable-element" data-tooltip="The bug I'm fixing at 3AM because I vibe-coded everything into chaos." data-orbit-radius="100" data-orbit-offset="3.14" data-rest-x="250" data-rest-y="350" style="cursor: grab;" filter="url(#iconShadow)">
                        <circle r="16" fill="rgba(40,40,40,0.95)" stroke="rgba(255,255,255,0.15)" stroke-width="1" />
                        <path d="M-5,-5 L5,5 M-5,5 L5,-5" stroke="#cf3f36" stroke-width="2.5" stroke-linecap="round" pointer-events="none" />
                    </g>

                    <!-- Physics Ball - Centered on inner orbit -->
                    <circle id="physics-ball" class="draggable-element" data-rest-x="250" data-rest-y="250" cx="250" cy="250" r="35" fill="url(#ballGrad)" filter="url(#shadow)" style="cursor: grab;" />
                </svg>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const container = document.getElementById('hero-svg-container');
                    const svg = document.getElementById('hero-interactive-svg');
                    if (!container || !svg) return;

                    const floatingIcons = document.querySelectorAll('.floating-icon');
                    const draggables = document.querySelectorAll('.draggable-element');

                    // Orbit radii
                    const orbitRadii = {
                        outer: 200,
                        middle: 150,
                        inner: 100
                    };

                    // State
                    let isHovering = false;
                    let orbitAngle = 0;
                    let orbitRotations = {
                        outer: 0,
                        middle: 0,
                        inner: 0
                    };

                    // Track which orbit each icon is on
                    const iconOrbits = new Map();
                    iconOrbits.set(document.getElementById('icon-code'), 'inner');
                    iconOrbits.set(document.getElementById('icon-close'), 'inner');

                    // Sarcastic messages for same-orbit conflict
                    const conflictMessages = [
                        "🚫 Code and bugs in the same orbit? That's called production!",
                        "⚠️ Nope! These two shouldn't share the same circle of trust.",
                        "🤦 Really? You want code and errors together? Bold move.",
                        "💥 Collision detected! Just like in real deployments.",
                        "🔥 They're incompatible. Like tabs and spaces people.",
                    ];

                    // Create tooltip element
                    const tooltip = document.createElement('div');
                    tooltip.id = 'orbit-tooltip';
                    tooltip.style.cssText = `
        position: fixed;
        background: rgba(30, 30, 30, 0.95);
        color: #ff6b5b;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        max-width: 280px;
        text-align: center;
        pointer-events: none;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 9999;
        border: 1px solid rgba(207, 63, 54, 0.3);
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    `;
                    document.body.appendChild(tooltip);

                    function showTooltip(x, y, message) {
                        tooltip.textContent = message;
                        tooltip.style.left = `${x}px`;
                        tooltip.style.top = `${y - 60}px`;
                        tooltip.style.opacity = '1';
                        tooltip.style.transform = 'translateY(0)';

                        setTimeout(() => {
                            tooltip.style.opacity = '0';
                            tooltip.style.transform = 'translateY(10px)';
                        }, 2500);
                    }

                    // Physics states for all draggable elements
                    const elementStates = new Map();

                    draggables.forEach((el) => {
                        const isCircle = el.tagName === 'circle';
                        const restX = parseFloat(el.dataset.restX) || (isCircle ? parseFloat(el.getAttribute('cx')) : 0);
                        const restY = parseFloat(el.dataset.restY) || (isCircle ? parseFloat(el.getAttribute('cy')) : 0);

                        elementStates.set(el, {
                            x: restX,
                            y: restY,
                            vx: 0,
                            vy: 0,
                            targetX: restX,
                            targetY: restY,
                            restX: restX,
                            restY: restY,
                            isDragging: false,
                            isCircle: isCircle
                        });
                    });

                    const friction = 0.88;
                    const springStrength = 0.06;

                    // Detect which orbit a position is closest to
                    function detectOrbit(x, y) {
                        const distFromCenter = Math.sqrt(Math.pow(x - 250, 2) + Math.pow(y - 250, 2));

                        // Find closest orbit
                        let closest = 'inner';
                        let minDiff = Math.abs(distFromCenter - orbitRadii.inner);

                        if (Math.abs(distFromCenter - orbitRadii.middle) < minDiff) {
                            minDiff = Math.abs(distFromCenter - orbitRadii.middle);
                            closest = 'middle';
                        }
                        if (Math.abs(distFromCenter - orbitRadii.outer) < minDiff) {
                            closest = 'outer';
                        }

                        return closest;
                    }

                    // Update orbit rotations
                    function updateOrbitRotations() {
                        if (!isHovering) {
                            orbitRotations.outer += 0.3;
                            orbitRotations.middle -= 0.5;
                            orbitRotations.inner += 0.4;
                            orbitAngle += 0.012;
                        }

                        document.getElementById('orbit-outer').style.transform = `rotate(${orbitRotations.outer}deg)`;
                        document.getElementById('orbit-middle').style.transform = `rotate(${orbitRotations.middle}deg)`;
                        document.getElementById('orbit-inner').style.transform = `rotate(${orbitRotations.inner}deg)`;

                        // Update floating icon positions along their assigned orbits
                        floatingIcons.forEach((icon) => {
                            const state = elementStates.get(icon);
                            if (!state.isDragging && !isHovering) {
                                const orbitName = iconOrbits.get(icon) || 'inner';
                                const radius = orbitRadii[orbitName];
                                const offset = parseFloat(icon.dataset.orbitOffset) || 0;
                                state.targetX = 250 + Math.cos(orbitAngle + offset) * radius;
                                state.targetY = 250 + Math.sin(orbitAngle + offset) * radius;
                            }
                        });
                    }

                    // Mouse enter/leave for orbit pause
                    container.addEventListener('mouseenter', function() {
                        isHovering = true;
                    });

                    container.addEventListener('mouseleave', function() {
                        isHovering = false;
                    });

                    // Dragging functionality for ALL draggable elements
                    draggables.forEach((el) => {
                        el.addEventListener('mousedown', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            const state = elementStates.get(el);
                            state.isDragging = true;
                            el.style.cursor = 'grabbing';
                        });

                        // Show funny tooltips on hover for icons
                        if (el.classList.contains('floating-icon')) {
                            el.addEventListener('mouseenter', function(e) {
                                const message = el.getAttribute('data-tooltip');
                                if (message && !elementStates.get(el).isDragging) {
                                    const rect = el.getBoundingClientRect();
                                    showTooltip(rect.left + rect.width / 2, rect.top, message);
                                }
                            });
                        }
                    });

                    document.addEventListener('mousemove', function(e) {
                        const rect = svg.getBoundingClientRect();
                        const svgX = (e.clientX - rect.left) / rect.width * 500;
                        const svgY = (e.clientY - rect.top) / rect.height * 500;

                        elementStates.forEach((state, el) => {
                            if (state.isDragging) {
                                state.targetX = Math.max(30, Math.min(470, svgX));
                                state.targetY = Math.max(30, Math.min(470, svgY));
                            }
                        });
                    });

                    document.addEventListener('mouseup', function(e) {
                        elementStates.forEach((state, el) => {
                            if (state.isDragging) {
                                state.isDragging = false;
                                el.style.cursor = 'grab';

                                // For floating icons, detect which orbit they're dropped on
                                if (el.classList.contains('floating-icon')) {
                                    const droppedOrbit = detectOrbit(state.x, state.y);
                                    const otherIcon = Array.from(floatingIcons).find(i => i !== el);
                                    const otherOrbit = iconOrbits.get(otherIcon);

                                    // Check if both icons would be on the same orbit
                                    if (droppedOrbit === otherOrbit) {
                                        // Show sarcastic message
                                        const message = conflictMessages[Math.floor(Math.random() * conflictMessages.length)];
                                        showTooltip(e.clientX, e.clientY, message);
                                        // Keep on current orbit, don't change
                                    } else {
                                        // Assign to new orbit
                                        iconOrbits.set(el, droppedOrbit);
                                        el.dataset.orbitRadius = orbitRadii[droppedOrbit];
                                    }
                                } else {
                                    // Non-icons spring back to rest
                                    state.targetX = state.restX;
                                    state.targetY = state.restY;
                                }
                            }
                        });
                    });

                    // Physics loop
                    function physicsLoop() {
                        updateOrbitRotations();

                        elementStates.forEach((state, el) => {
                            // Spring physics
                            const dx = state.targetX - state.x;
                            const dy = state.targetY - state.y;

                            state.vx += dx * springStrength;
                            state.vy += dy * springStrength;
                            state.vx *= friction;
                            state.vy *= friction;

                            state.x += state.vx;
                            state.y += state.vy;

                            // Apply position
                            if (state.isCircle) {
                                el.setAttribute('cx', state.x);
                                el.setAttribute('cy', state.y);
                            } else {
                                el.setAttribute('transform', `translate(${state.x}, ${state.y})`);
                            }
                        });

                        requestAnimationFrame(physicsLoop);
                    }

                    physicsLoop();
                });
            </script>
        </div>
        </div>
    </section>

    <style>
        .text-accent {
            color: var(--accent-color);
        }

        .bg-accent {
            background-color: var(--accent-color);
        }

        .bg-accent\/10 {
            background-color: rgba(207, 63, 54, 0.1);
        }

        /* Stat Card Tooltips */
        .stat-card-tooltip {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card-tooltip:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(207, 63, 54, 0.15);
        }

        .stat-card-tooltip::before {
            content: attr(data-tooltip);
            position: absolute;
            top: -60px;
            left: 100%;
            transform: translateX(-50%) translateY(-5px);
            padding: 10px 16px;
            background: rgba(25, 25, 30, 0.97);
            color: #ff6b5b;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            border-radius: 10px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 100;
            pointer-events: none;
            border: 1px solid rgba(207, 63, 54, 0.25);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .stat-card-tooltip::after {
            content: '';
            position: absolute;
            top: -16px;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: rgba(25, 25, 30, 0.97);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 101;
        }

        .stat-card-tooltip:hover::before,
        .stat-card-tooltip:hover::after {
            opacity: 1;
            visibility: visible;
        }

        .stat-card-tooltip:hover::before {
            transform: translateX(-50%) translateY(0);
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float-slow {
            animation: float-slow 6s ease-in-out infinite;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
                transform-origin: center;
            }

            to {
                transform: rotate(360deg);
                transform-origin: center;
            }
        }

        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        @keyframes spin-reverse {
            from {
                transform: rotate(360deg);
                transform-origin: center;
            }

            to {
                transform: rotate(0deg);
                transform-origin: center;
            }
        }

        .animate-spin-reverse {
            animation: spin-reverse 25s linear infinite;
        }
    </style>

    @push('front_js')
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Counter for visited users and views
            const counterElement = document.getElementById('counter');
            const viewsElement = document.getElementById('views');

            // Assuming $usersAndViews is a PHP variable containing an array
            const activeUsers = {{ $usersAndViews['activeUsers'] ?? 0 }};
            const screenPageViews = {{ $usersAndViews['screenPageViews'] ?? 0 }};

            const duration = 2000; // 2 seconds to reach the target value

            // Easing function for smooth animation (easeOutExpo)
            const easeOutExpo = (t) => {
                return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
            };

            const updateCounter = (element, target) => {
                const startTime = performance.now();

                const animate = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Apply easing function
                    const easedProgress = easeOutExpo(progress);
                    const currentCount = Math.floor(easedProgress * target);

                    element.textContent = currentCount + '+';

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        element.textContent = target + '+';
                    }
                };

                requestAnimationFrame(animate);
            };

            updateCounter(counterElement, activeUsers);
            updateCounter(viewsElement, screenPageViews);

            // Typing effect for backforthtexts
            var backforthtexts = [
                @foreach($backforthtext as $backforthtextss)
                "{{ $backforthtextss->name }}",
                @endforeach
            ];

            var typingEffect = new Typed(".multiText", {
                strings: backforthtexts,
                loop: true,
                typeSpeed: 200,
                backSpeed: 100,
                backDelay: 1000,
                startDelay: 500,
                smartBackspace: true, // Only backspace what doesn't match the previous string
                shuffle: false,
                fadeOut: false,
                fadeOutClass: 'typed-fade-out',
                fadeOutDelay: 500,
                showCursor: true,
                cursorChar: '_',
                autoInsertCss: true
            });
        });
    </script>
    @endpush