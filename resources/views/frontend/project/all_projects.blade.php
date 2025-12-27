@extends('layouts.front_master')
@section('title', 'Projects')
@section('content')

<div class="container-fluid project-lists">
    <br>
    <br>
    <br>
    <br>
    <h2 class="">All Projects</h2>
    <hr>
    <div class="row py-2 mb-3 align-items-center">
        <div class="col-sm-3">
            <h5 class=" project-headers">Year</h5>
        </div>
        <div class="col-sm-6">
            <h5 class="project-headers">Projects</h5>
        </div>
        <div class="col-sm-3">
            <h5 class="project-headers">Built With</h5>
        </div>
    </div>

    @foreach ($projects as $key => $project)
    <div class="row d-flex justify-content-center">

        <div class="col-sm-3" style="color: #747884; ">{{ optional($project)->year }}</div>

        <div class="col-sm-6 mb-2">
            <div class="d-flex">
                <a href="{{ optional($project)->web_url }}" class=" project-title text-decoration-none d-flex me-2">
                    <img src="{{ optional($project)->image_path }}" alt="{{ optional($project)->name }}" width="40"
                        height="40" class="project-img me-2" style=" object-fit: cover;" />
                    <h6>{{ optional($project)->name }}</h6>
                    <svg style="width: 25px; height: 25px;" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20"
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
            </p>

        </div>

        <div class="col-sm-3">
            <p>
                @php
                $techs = json_decode(optional($project)->tech_used);
                @endphp
                @if ($techs)
                @foreach ($techs as $key => $tech)
                <span class="m-1 badge"> {{ $tech }}</span>
                @endforeach
                @endif
            </p>
        </div>
        <hr>
        @endforeach
    </div>

    <p class="text-center">And other projects that I'm not comfortable/allowed to share publicly :)</p>
</div>

@endsection