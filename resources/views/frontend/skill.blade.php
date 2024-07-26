<section class="skills" id="skills">
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
        <style>
            .progress {
                height: 20px;
                align-items: center;
                justify-content: center;
            }

            .progresscards {
                margin-left: 10px;
                margin-right: 10px;
            }

            .info {
                color: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
                font-weight: 500;
                padding: 0 10px;
                font-size: 18px;
            }

            .progress-container {
                height: 20px;
                border-radius: 50px;
                background-color: #000;
                position: relative;
                overflow: hidden;
            }

            .bg-dark {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #333;
            }

            .line-html {
                height: 100%;
                border-radius: 50%;
                width: 0;
                position: absolute;
                animation: progressAnimation 5s linear infinite;
            }

            @keyframes progressAnimation {
                0% {
                    width: 0;
                }
            }

            .skillCards {
                width: 200px;
                height: 170px;
                background-color: #000;
                position: relative;
                overflow: hidden;
                padding: 10px;
                transition: all 0.5s ease-in-out;
                margin: 20px;
                border-radius: 10px;
            }

            .skillCards>img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            }

            .content {
                position: absolute;
                bottom: -300px;
                left: 50px;
                color: #fff;
                transition: all 0.5s ease-in-out;
                margin-bottom: 25px;
            }

            .skillCards:hover .content {
                bottom: 10px;
            }

            .skillCards:hover>img,
            .skillCards:hover>.progresscards {
                filter: brightness(0);
            }

            .skillCards:hover {
                transform: scale(0.98);
                border-radius: 20px;
                box-shadow: 0px 0px 30px 1px rgba(255, 55, 9, 0.45);
            }

            @media (max-width: 768px) {
                .skillCards {
                    width: 120px;
                    height: 120px;
                }

                .content img {
                    width: 50px;
                    height: 50px;
                }

                .content {
                    bottom: 150px;
                    left: 35px;
                    margin-bottom: 25px;
                }
            }
        </style>
    </div>

</section>
