<div class="container-fluid" id="skills">
    <br>
    <br>
    <h4 class="mx-5">Skills</h4>
    <hr>
    <div class="skills-content mt-5">
        <div class="skillssection  d-flex justify-content-center align-items-center flex-wrap">
            @foreach ($skills as $skill)
                <div class="skillCards col-lg-3 col-md-6 ">
                    <img src="{{ optional($skill)->image_path }}" alt="" />
                    <div class="progresscards">
                        <span class="info">{{ optional($skill)->name }}</span>
                        <div class="progress-container mt-1">
                            <div class="bg-dark"></div>
                            <div class="line-html">
                                <span class="progress">{{ optional($skill)->percentage }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="content">
                        <img src="{{ optional($skill)->image_path }}" alt="" height="100" width="100" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('front_js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            animateProgressBar();
        });

        function animateProgressBar() {
            var progressContainers = document.querySelectorAll(".progress-container");
            progressContainers.forEach(function(container) {
                var progressElement = container.querySelector(".line-html .progress");
                var progressBar = container.querySelector(".line-html");

                var progress = parseInt(progressElement.innerText);
                progressBar.style.width = progress + "%";
            });
        }
    </script>
@endpush
