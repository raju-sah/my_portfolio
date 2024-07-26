<section class="speciality" id="speciality">
    <div class="container-fluid project-lists">
        <br>
        <br>
        <h4 class="mx-5">Projects</h4>
        <hr>
        @foreach ($projects as $key => $project)
            <div class=" projects row d-flex mx-auto justify-content-center" style="max-width: 900px; mb-3">
                <p class="col-sm-3" style="color: #747884; ">{{ optional($project)->year }}</p>
                <div class="col-sm-9 mb-3">
                    <div class="d-flex">
                        <a href="{{ optional($project)->web_url }}"
                            class=" project-title text-decoration-none d-flex me-2">
                            <img src="{{ optional($project)->image_path }}" alt="{{ optional($project)->name }}"
                                width="40" height="40" class="project-img me-2" style=" object-fit: cover;" />
                            <h6>{{ optional($project)->name }}</h6>
                            <svg style="width: 25px; height: 25px;" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20"
                                class="project-svg inline-block h-1 w-1 shrink-0 transition-transform group-hover/title:-translate-y-1 group-hover/title:translate-x-1 motion-reduce:transition-none">
                                <path
                                    d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06z">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ optional($project)->github_url }}" target="_blank"><i
                                class="fa-brands fa-square-github"></i></a>
                    </div>
                    <p>
                        {!! optional($project)->description !!}

                        @php
                            $techs = json_decode(optional($project)->tech_used);
                        @endphp
                        @if ($techs)
                            @foreach ($techs as $key => $tech)
                                <span class="badge"> {{ $tech }}</span>
                            @endforeach
                        @endif
                    </p>
                </div>
        @endforeach
    </div>

    <a href="{{ route('projects.all') }}" class="text-decoration-none more">
        <i class="fa-solid fa-angle-up" style="color: #cf3f36"></i>
        <span class="more-projects">More projects....</span>
    </a>
    </div>

</section>
