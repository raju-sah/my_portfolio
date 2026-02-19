@extends('layouts.front_master')

@section('content')
@include('frontend.hero')
@include('frontend.project.project_list')
@include('frontend.experience')
@include('frontend.skill')
@include('frontend.article.home_article')
@include('frontend.contact')
@endsection

@push('front_js')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@include('_helpers.country_dial_code', ['id' => 'phone'])

<script>
    let storeRoute = "{{ route('contact.store') }}";
</script>

@include('_helpers.single_page_table_ajax', ['formId' => '#contact_form'])

<script type="text/javascript">
    // Register ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    // Parallax and Reveal Animation for Text
    document.addEventListener('DOMContentLoaded', function() {
        gsap.utils.toArray('.scroll-reveal-text').forEach(text => {
            gsap.to(text, {
                backgroundSize: '100% 100%',
                y: -150, // Parallax effect
                ease: 'none',
                scrollTrigger: {
                    trigger: text,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                }
            });
        });

        // Smoothing the transition between background and text colors
        const updateAllSections = () => {
            const isLight = document.documentElement.getAttribute('data-theme') === 'light';

            // Clear existing triggers to avoid conflicts on theme switch
            ScrollTrigger.getAll().forEach(st => {
                if (st.vars.id && st.vars.id.includes('theme-')) st.kill();
            });

            gsap.utils.toArray('.scroll-section').forEach((section, i) => {
                const bg = isLight ? section.getAttribute('data-bg-light') : section.getAttribute('data-bg');
                const text = isLight ? section.getAttribute('data-text-light') : section.getAttribute('data-text');

                if (!bg || !text) return;

                ScrollTrigger.create({
                    id: `theme-${i}`,
                    trigger: section,
                    start: 'top 70%', // Start transition earlier
                    end: 'bottom 30%', // End transition later to ensure overlap
                    onToggle: self => {
                        if (self.isActive) {
                            gsap.to(['body', document.documentElement], {
                                backgroundColor: bg,
                                color: text,
                                '--bg-primary': bg,
                                '--text-heading': text,
                                '--text-body': text,
                                duration: 0.8,
                                overwrite: 'auto',
                                ease: "power2.inOut"
                            });
                        }
                    },
                    onEnter: () => {
                        if (i === 0 && window.scrollY < 100) {
                            gsap.set(['body', document.documentElement], {
                                backgroundColor: bg,
                                color: text,
                                '--bg-primary': bg,
                                '--text-heading': text,
                                '--text-body': text
                            });
                        }
                    }
                });
            });
        };

        updateAllSections();

        // Watch for theme toggle changes
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                    updateAllSections();
                    ScrollTrigger.refresh();
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true
        });

        // ================================================================
        //            3D ROAD JOURNEY — Experience Animation Engine
        // ================================================================
        const roadContainer = document.getElementById('roadContainer');
        const roadSvg = document.getElementById('roadSvg');
        const stations = document.querySelectorAll('.road-station');

        if (roadContainer && roadSvg && stations.length > 0) {

            const isMobile = window.innerWidth <= 768;

            // ---------- Mobile: simple fade-in ----------
            if (isMobile) {
                stations.forEach((station, i) => {
                    ScrollTrigger.create({
                        trigger: station,
                        start: 'top 88%',
                        once: true,
                        onEnter: () => {
                            gsap.to(station, {
                                opacity: 1,
                                y: 0,
                                scale: 1,
                                duration: 0.7,
                                delay: 0.1,
                                ease: 'back.out(1.4)',
                                onComplete: () => station.classList.add('is-reached')
                            });
                        }
                    });
                });
            }

            // ---------- Desktop: Full Road Journey ----------
            if (!isMobile) {
                const roadBody = document.getElementById('roadBody');
                const roadGlowPath = document.getElementById('roadGlowPath');
                const roadCenter = document.getElementById('roadCenter');
                const travelerTrail = document.getElementById('travelerTrail');
                const travelerDot = document.getElementById('travelerDot');
                const travelerCore = document.getElementById('travelerCore');
                const milestoneGroup = document.getElementById('milestoneGroup');

                // ================================================================
                //            EXTREME CREATIVITY ENHANCEMENTS
                // ================================================================

                // 1. Celestial Starfield (Canvas)
                const starCanvas = document.getElementById('roadStars');
                const ctx = starCanvas.getContext('2d');
                let stars = [];
                const starCount = 150;

                function initStars() {
                    starCanvas.width = roadContainer.offsetWidth;
                    starCanvas.height = roadContainer.offsetHeight;
                    stars = [];
                    for (let i = 0; i < starCount; i++) {
                        stars.push({
                            x: Math.random() * starCanvas.width,
                            y: Math.random() * starCanvas.height,
                            size: Math.random() * 1.5 + 0.5,
                            speed: Math.random() * 0.5 + 0.1,
                            opacity: Math.random() * 0.5 + 0.2
                        });
                    }
                }

                function drawStars(scrollVelocity = 0) {
                    ctx.clearRect(0, 0, starCanvas.width, starCanvas.height);
                    const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--accent-color');

                    stars.forEach(star => {
                        // Move stars based on scroll velocity (simulating warp)
                        star.y -= (star.speed + Math.abs(scrollVelocity) * 0.1);
                        if (star.y < 0) star.y = starCanvas.height;
                        if (star.y > starCanvas.height) star.y = 0;

                        ctx.globalAlpha = star.opacity;
                        ctx.fillStyle = star.size > 1.2 ? accentColor : '#fff';
                        ctx.beginPath();
                        ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
                        ctx.fill();
                    });
                    requestAnimationFrame(() => drawStars(window.lastVelocity || 0));
                }

                initStars();
                drawStars();

                // 2. Interactive 3D Tilt
                stations.forEach(station => {
                    const card = station.querySelector('.station-card');
                    if (!card) return;

                    station.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;

                        const rotateX = (y - centerY) / 10;
                        const rotateY = (centerX - x) / 10;

                        gsap.to(card, {
                            rotateX: rotateX,
                            rotateY: rotateY,
                            duration: 0.5,
                            ease: 'power2.out'
                        });
                    });

                    station.addEventListener('mouseleave', () => {
                        gsap.to(card, {
                            rotateX: 0,
                            rotateY: 0,
                            duration: 0.5,
                            ease: 'power2.out'
                        });
                    });
                });

                // 3. Milestone Shockwave Trigger
                function triggerShockwave(x, y) {
                    const wave = document.createElement('div');
                    wave.className = 'shockwave';
                    wave.style.left = `${x}px`;
                    wave.style.top = `${y}px`;
                    roadContainer.appendChild(wave);

                    wave.style.animation = 'shockwave-expand 0.6s ease-out forwards';
                    setTimeout(() => wave.remove(), 600);
                }

                // 4. Parallax Floating Assets
                const floatingAssets = document.querySelectorAll('.road-asset');

                function buildRoad() {
                    // Kill existing road-related ScrollTriggers
                    ScrollTrigger.getAll().forEach(st => {
                        if (st.vars.id && st.vars.id.startsWith('road-')) st.kill();
                    });

                    const containerRect = roadContainer.getBoundingClientRect();
                    const containerW = containerRect.width;
                    const containerH = roadContainer.scrollHeight;

                    // Resize Starfield
                    starCanvas.width = containerW;
                    starCanvas.height = containerH;

                    // Size the SVG
                    roadSvg.setAttribute('width', containerW);
                    roadSvg.setAttribute('height', containerH);
                    roadSvg.setAttribute('viewBox', `0 0 ${containerW} ${containerH}`);

                    // Calculate waypoints from station positions
                    const centerX = containerW * 0.5;
                    const waypoints = [];

                    // Start point (top center)
                    waypoints.push({
                        x: centerX,
                        y: 20
                    });

                    stations.forEach((station, i) => {
                        const stationRect = station.getBoundingClientRect();
                        const containerTop = containerRect.top;
                        const stationY = stationRect.top - containerTop + 35;
                        const isLeft = station.classList.contains('road-left');

                        // Road passes through center, with curves toward each station
                        if (isLeft) {
                            // Road curves left
                            waypoints.push({
                                x: centerX - containerW * 0.02,
                                y: stationY - 60
                            });
                            waypoints.push({
                                x: centerX - containerW * 0.03,
                                y: stationY
                            });
                            waypoints.push({
                                x: centerX - containerW * 0.02,
                                y: stationY + 60
                            });
                        } else {
                            // Road curves right
                            waypoints.push({
                                x: centerX + containerW * 0.02,
                                y: stationY - 60
                            });
                            waypoints.push({
                                x: centerX + containerW * 0.03,
                                y: stationY
                            });
                            waypoints.push({
                                x: centerX + containerW * 0.02,
                                y: stationY + 60
                            });
                        }
                    });

                    // End point
                    waypoints.push({
                        x: centerX,
                        y: containerH - 20
                    });

                    // Build smooth cubic bezier path through waypoints
                    let d = `M ${waypoints[0].x} ${waypoints[0].y}`;
                    for (let i = 1; i < waypoints.length - 1; i += 3) {
                        const p1 = waypoints[i];
                        const p2 = waypoints[i + 1] || waypoints[waypoints.length - 1];
                        const p3 = waypoints[i + 2] || waypoints[waypoints.length - 1];
                        d += ` C ${p1.x} ${p1.y}, ${p2.x} ${p2.y}, ${p3.x} ${p3.y}`;
                    }

                    // Apply path to all road elements
                    roadBody.setAttribute('d', d);
                    roadGlowPath.setAttribute('d', d);
                    roadCenter.setAttribute('d', d);
                    travelerTrail.setAttribute('d', d);

                    // Get total path length
                    const totalLength = roadCenter.getTotalLength();

                    // Setup stroke dash for road center line
                    roadCenter.style.strokeDashoffset = '0';

                    // Setup traveler trail (starts fully hidden)
                    travelerTrail.style.strokeDasharray = totalLength;
                    travelerTrail.style.strokeDashoffset = totalLength;

                    // Calculate station positions along the path
                    const stationPositions = [];
                    stations.forEach((station, i) => {
                        const stationRect = station.getBoundingClientRect();
                        const containerTop = containerRect.top;
                        const stationY = stationRect.top - containerTop + 35;

                        // Find the path position closest to this station's Y coordinate
                        let bestLen = 0;
                        let bestDist = Infinity;
                        for (let len = 0; len <= totalLength; len += 5) {
                            const pt = roadCenter.getPointAtLength(len);
                            const dist = Math.abs(pt.y - stationY);
                            if (dist < bestDist) {
                                bestDist = dist;
                                bestLen = len;
                            }
                        }
                        stationPositions.push(bestLen / totalLength);
                    });

                    // Place milestone markers on the road
                    milestoneGroup.innerHTML = '';
                    stationPositions.forEach((pos, i) => {
                        const pt = roadCenter.getPointAtLength(pos * totalLength);
                        const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                        circle.setAttribute('cx', pt.x);
                        circle.setAttribute('cy', pt.y);
                        circle.setAttribute('r', 14);
                        circle.setAttribute('class', 'milestone-circle');
                        circle.style.opacity = '0';

                        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                        text.setAttribute('x', pt.x);
                        text.setAttribute('y', pt.y);
                        text.setAttribute('class', 'milestone-text');
                        text.textContent = String(i + 1).padStart(2, '0');
                        text.style.opacity = '0';

                        milestoneGroup.appendChild(circle);
                        milestoneGroup.appendChild(text);
                    });

                    const milestones = milestoneGroup.querySelectorAll('.milestone-circle, .milestone-text');

                    // Position traveler at start
                    const startPt = roadCenter.getPointAtLength(0);
                    travelerDot.setAttribute('cx', startPt.x);
                    travelerDot.setAttribute('cy', startPt.y);
                    travelerCore.setAttribute('cx', startPt.x);
                    travelerCore.setAttribute('cy', startPt.y);

                    // Track which stations have been revealed
                    const revealed = new Array(stations.length).fill(false);

                    // ---- Main scroll-driven animation ----
                    ScrollTrigger.create({
                        id: 'road-main',
                        trigger: roadContainer,
                        start: 'top 75%',
                        end: 'bottom 25%',
                        scrub: 0.3,
                        onUpdate: (self) => {
                            const progress = self.progress;
                            window.lastVelocity = self.getVelocity();

                            // Move traveler along path
                            const currentLen = progress * totalLength;
                            const pt = roadCenter.getPointAtLength(currentLen);
                            travelerDot.setAttribute('cx', pt.x);
                            travelerDot.setAttribute('cy', pt.y);
                            travelerCore.setAttribute('cx', pt.x);
                            travelerCore.setAttribute('cy', pt.y);

                            // Draw trail behind traveler
                            travelerTrail.style.strokeDashoffset = totalLength - currentLen;

                            // Parallax floating assets
                            floatingAssets.forEach(asset => {
                                const speed = parseFloat(asset.dataset.speed || 1);
                                gsap.set(asset, {
                                    y: -progress * 200 * speed
                                });
                            });

                                // Reveal stations as traveler passes them
                                stationPositions.forEach((stationPos, i) => {
                                    const station = stations[i];
                                    const card = station.querySelector('.station-card');
                                    const shimmer = station.querySelector('.card-shimmer');
                                    const isLeft = station.classList.contains('road-left');
                                    
                                    // Calculate proximity for reactive glow (distance in progress units)
                                    const dist = Math.abs(progress - stationPos);
                                    
                                    // Complex Holographic Shimmer logic
                                    if (shimmer) {
                                        // Move shimmer based on scroll progress
                                        const shimmerPos = (progress * 500) % 200;
                                        shimmer.style.setProperty('--shimmer-pos', `${shimmerPos}%`);
                                    }

                                    // Exact Reveal Threshold (0% - reveal exactly on contact)
                                    if (!revealed[i] && progress >= stationPos) {
                                        revealed[i] = true;

                                        // Trigger shockwave at the milestone point
                                        const milestonePt = roadCenter.getPointAtLength(stationPos * totalLength);
                                        triggerShockwave(milestonePt.x, milestonePt.y);

                                        // 3D "Unfold" reveal animation
                                        gsap.fromTo(station, 
                                            { 
                                                opacity: 0, 
                                                scale: 0.8,
                                                rotateX: -45,
                                                rotateY: isLeft ? -30 : 30,
                                                z: -100
                                            },
                                            {
                                                opacity: 1,
                                                scale: 1,
                                                rotateX: 0,
                                                rotateY: 0,
                                                z: 0,
                                                duration: 1.5,
                                                ease: 'expo.out',
                                                onComplete: () => {
                                                    station.classList.add('is-reached');
                                                }
                                            }
                                        );

                                        // Reveal corresponding milestone marker
                                        const circles = milestoneGroup.querySelectorAll('.milestone-circle');
                                        const texts = milestoneGroup.querySelectorAll('.milestone-text');
                                        if (circles[i]) gsap.to(circles[i], { opacity: 1, duration: 0.5 });
                                        if (texts[i]) gsap.to(texts[i], { opacity: 1, duration: 0.5, delay: 0.1 });
                                    }
                                });
                        }
                    });
                }

                // Build on load & resize
                buildRoad();

                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        if (window.innerWidth > 768) {
                            buildRoad();
                            ScrollTrigger.refresh();
                        }
                    }, 250);
                });
            }
        }
    });

    $(document).ready(function() {
        const btn_submit = $('.btn_submit');

        $('#contact_form').on('submit', function(e) {
            e.preventDefault();
            const pri_min = $('#pri_min').val();

            if (pri_min !== '') {

                Swal.fire({
                    icon: 'error',
                    title: 'Fake Content detected!',
                }).then((result) => {
                    $('#contact_form')[0].reset();

                });

            } else {
                saveData();

            }
        });

        $(document).on('fetchEvent', function() {});

        $(document).on('click', '.btn_submit', function() {
            $('html, body').animate({
                // scrollTop: '-=100px' // Scroll up by 100 pixels
                scrollTop: $('#contact_form').offset().top - 60
            }, 'fast');
        });
    });
</script>
@endpush