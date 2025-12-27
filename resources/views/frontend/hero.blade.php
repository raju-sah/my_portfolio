    <style>
        .counter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .counter-container{
           i, span {
            font-size: clamp(0.5em, 1vw + 0.8em, 3em);
        }

        #views, #counter {
            font-size: clamp(1em, 2vw + 1em, 3em);
            color: #cf3f36;
        }

        }
       
    </style>

    <section class="header">
        <div class="wrapper">
            <div class="cols cols0">
                <span class="topline">Hello I'm</span>
                @include('frontend.sandAnimation.sandAnimation')

                <h1 style="color: #a6adbb;"><span
                        style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-weight: bolder; font-size: 1.5em">A</span>
                    <span class="multiText"></span></h1>
                <p class="text-center">
                    {!! optional($home_setting)->description !!}
                </p>

                <p class="text-center mt-3 fw-lighter" style="color: #747884">I am usually occupied, but open to new
                    opportunities, hit me on Linkedin for chat. </p>

                <div class="counter-container d-flex align-items-center" style="font-size: 7px">
                    <i class="fa-regular fa-eye mb-5 me-4" style="color: #a6adbb">
                        <span class="fw-bolder" id="views"></span>
                        <span class="fw-bold ms-2">Views</span>
                    </i>
                    <i class="fa-solid fa-users mb-5" style="color: #a6adbb">
                        <span class="fw-bolder" id="counter"></span>
                        <span class="fw-bold ms-2">Visitors</span>
                    </i>
                </div>
            </div>
        </div>
    </section>

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
                    @foreach ($backforthtext as $backforthtextss)
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
                    cursorChar: '|',
                    autoInsertCss: true,
                    showCursor: true,
                    cursorChar: '_',
                    autoInsertCss: true
                });
            });
        </script>
    @endpush
