@extends('layouts.master')

@section('content')
    <style>
        .count-active-line::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 5px;
            background-color: rgb(221, 56, 14);
        }
    </style>
    <div class="container-xxl">
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3">
                <x-dashboard.stat-card icon="bx bx-user" class=" count-card count-active-line" style="position: relative"
                    color="dark" name="Contact" count="{{ \App\Models\Contact::count() }}"
                    link="{{ route('admin.contacts.index') }}" />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-dashboard.stat-card icon="bx bx-user" class="count-card" color="warning" name="Review"
                    count="{{ \App\Models\Review::count() }}" link="{{ route('admin.reviews.index') }}" />
            </div>

            <div class="col-sm-6 col-lg-3">
                <x-dashboard.stat-card icon="bx bx-user" class="count-card" color="success" name="Project"
                    count="{{ \App\Models\Project::count() }}" link="{{ route('admin.projects.index') }}" />
            </div>

            <div class="col-sm-6 col-lg-3">
                <x-dashboard.stat-card icon="bx bx-user" class="count-card" color="danger" name="Article"
                    count="{{ \App\Models\Article::count() }}" link="{{ route('admin.articles.index') }}" />
            </div>
        </div>

        @include('admin.dashboard.filterChart+PieChart')

        <div class=" d-flex justify-content-between">
            @include('admin.dashboard.world_map')
            @include('admin.dashboard.top_country')
            @include('admin.dashboard.top_city')
        </div>

        <div class="d-flex mt-3">
            @include('admin.dashboard.userSourceChart')
            @include('admin.dashboard.userSourceCard')
        </div>

        <div class="d-flex mt-3">
            @include('admin.dashboard.operatingSystemChart')
            @include('admin.dashboard.operatingSystemCard')
        </div>

        <div class="d-flex mt-3">
            @include('admin.dashboard.deviceChart')
            @include('admin.dashboard.deviceCard')
        </div>

        <div class="row d-flex mt-5">
            @include('admin.dashboard.views_by_pagetitle')
        </div>
        <h2 class="mt-4" style="text-underline-position: under; text-decoration: underline dashed 1px  #000;">
            Analytics Filters</h2>
        @include('admin.dashboard.analyticsFilter')
    </div>
@endsection

@push('custom_js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const countCard = document.querySelectorAll('.count-card');

        countCard.forEach(card => {
            card.addEventListener('click', function() {
                // Remove the active-line class from all countCard
                countCard.forEach(c => c.classList.remove('count-active-line'));

                // Add the active-line class to the clicked card
                this.classList.add('count-active-line');
            });
        });
    </script>
@endpush
