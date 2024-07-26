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

                <div class="counter-container d-flex align-items-center">
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

                const increment = 1; // You can adjust this to make the counter go faster or slower
                const duration = 2000; // 2 seconds to reach the target value

                const updateCounter = (element, target) => {
                    let count = 0;
                    const intervalTime = duration / (target / increment);

                    const timer = setInterval(() => {
                        count += increment;
                        element.textContent = count + '+';

                        if (count >= target) {
                            clearInterval(timer);
                            element.textContent = target + '+';
                        }
                    }, intervalTime);
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
                    typeSpeed: 100,
                    backSpeed: 80,
                    backDelay: 1500
                });
            });
        </script>
    @endpush
