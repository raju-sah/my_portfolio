<div class="container-fluid">
    <br>
    <br>
    <h4 class="mx-5">Experiences</h4>
    <hr>
    <div class="row d-flex mx-auto py-2 justify-content-center align-items-center" style="max-width: 950px">
        <div class="col-sm-5">
            <h6 class=" experience-headers">Designation</h6>
        </div>
        <div class="col-sm-7">
            <h6 class=" experience-headers">Company</h6>
        </div>
    </div>

    @foreach ($experiences as $key => $experience)
        <div class="row d-flex mx-auto justify-content-center" style="max-width: 950px; ">
            <div class="col-sm-5 mb-3">
                <span style="color: #a6adbb;">{{ optional($experience)->role }}</span>
                <span style="color: #747884"> (
                    {{ optional($experience)->date_from . '-' . (optional($experience)->curently_here ? 'Present' : optional($experience)->date_to) }})</span>
            </div>

            <div class="col-sm-7 mb-2">
                <div class="d-flex">
                    <a href="{{ optional($experience)->web_url }}"
                        class=" project-title text-decoration-none d-flex me-2">
                        <img src="{{ optional($experience)->image_path }}" alt="{{ optional($experience)->name }}"
                            width="40" height="40" class="experience-img me-2" style=" object-fit: cover;" />
                        <h6>{{ optional($experience)->name }}</h6>
                        <svg style="width: 25px; height: 25px;" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20"
                            class="experience-svg inline-block h-1 w-1 shrink-0 transition-transform group-hover/title:-translate-y-1 group-hover/title:translate-x-1 motion-reduce:transition-none">
                            <path
                                d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06z">
                            </path>
                        </svg>
                    </a>
                </div>
                <p>
                    {!! optional($experience)->description !!}
                </p>
            </div>

            <hr>
    @endforeach
</div>
</div>
</section>
