@extends('layouts.front_master')
@section('title', 'Projects')
@section('content')

<section class="relative py-20">
    <div class="container mx-auto px-6 relative z-10">
        <h2 class="text-4xl font-black text-heading mb-4">All Projects</h2>
        <p class="text-body/70 mb-12">A comprehensive archive of my work over the years.</p>
        
        {{-- Table Header --}}
        <div class="hidden md:grid grid-cols-12 gap-6 text-sm font-semibold text-body/50 uppercase tracking-widest pb-4 border-b border-heading/10">
            <div class="col-span-2">Year</div>
            <div class="col-span-7">Project</div>
            <div class="col-span-3">Built With</div>
        </div>

        {{-- Projects List --}}
        <div class="divide-y divide-heading/5">
            @foreach ($projects as $key => $project)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 py-6 group hover:bg-card/20 -mx-4 px-4 rounded-xl transition-all">
                
                {{-- Year --}}
                <div class="md:col-span-2">
                    <span class="font-mono text-body/50 text-sm">{{ optional($project)->year }}</span>
                </div>

                {{-- Project Info --}}
                <div class="md:col-span-7">
                    <div class="flex items-center gap-4 mb-3">
                        <a href="{{ optional($project)->web_url }}" target="_blank" class="flex items-center gap-3 group/link text-heading font-bold text-lg hover:text-accent transition-colors">
                            <img src="{{ optional($project)->image_path }}" alt="{{ optional($project)->name }}" class="w-10 h-10 object-cover rounded-lg shadow-sm" />
                            <span>{{ optional($project)->name }}</span>
                            <svg class="w-4 h-4 opacity-0 group-hover/link:opacity-100 transition-all -translate-x-1 group-hover/link:translate-x-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        <a href="{{ optional($project)->github_url }}" target="_blank" class="text-body/50 hover:text-heading transition-colors">
                            <i class="fa-brands fa-github text-xl"></i>
                        </a>
                    </div>
                    <p class="text-body leading-relaxed text-sm max-w-2xl">
                        {!! optional($project)->description !!}
                    </p>
                </div>

                {{-- Tech Stack --}}
                <div class="md:col-span-3">
                    <div class="flex flex-wrap gap-2">
                        @php
                            $techs = json_decode(optional($project)->tech_used);
                        @endphp
                        @if ($techs)
                            @foreach ($techs as $key => $tech)
                                <span class="px-2 py-1 text-[10px] uppercase font-bold tracking-wider text-accent border border-accent/20 rounded bg-accent/5">{{ $tech }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <p class="text-center text-body/50 mt-16 text-sm italic">And other projects that I'm not comfortable/allowed to share publicly :)</p>
    </div>
</section>

@endsection