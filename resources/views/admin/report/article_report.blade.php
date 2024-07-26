@extends('layouts.master')
@section('title', 'Article Report')
@section('content')
    <div class="container-xxl">
        <x-breadcrumb model="Article Reports"></x-breadcrumb>
        <div class="card">
            <div class="card-body">
                <x-form.wrapper action="{{ route('admin.article-reports.index') }}" method="GET">
                    <div class="d-flex align-items-end">
                        <x-form.select label="Select Article" col="8" :option-display="false" class="select_two_articles"
                            :options="$articles" name="article_id" required value="{{ $filtered_article?->id }}" selected />
                        <div class="col-md-2">
                            <x-form.button class="btn btn-dark ms-3" type="submit"><i class='bx bx-xs bxs-report'></i>
                                Generate Report</x-form.button>
                        </div>
                    </div>
                </x-form.wrapper>
            </div>
        </div>
        @if ($filtered_article)
            <div class="card mt-2">
                <div class="card-body">
                    <form action="{{ route('admin.article.generate-pdf', $filtered_article->id) }}" method="GET">
                        <input type="hidden" name="article_id" value="{{ $filtered_article->id }}">
                        <button type="submit" class="btn btn-sm btn-primary"><i class='bx bx-xs bxs-file-pdf'></i>Download
                            Report PDF</button>
                    </form>
                    <div class="title-section d-flex align-items-center justify-content-between mt-3 mb-2">
                        <span class="fw-bold fs-3">{{ $filtered_article->name }}</span>
                        <span class=" mt-2"><i class="bx bx-show-alt"></i>{{ $filtered_article->views }} Views</span>
                        <div class="d-flex align-items-end ms-3">
                            <span>Average Rating:
                                @for ($i = 0; $i < $filtered_article->reviews_avg_rating; $i++)
                                    <i class='bx bxs-star' style="color: #ffc700;"></i>
                                @endfor
                            </span>
                            <span>({{ $filtered_article->reviews_avg_rating }}
                                {{ Str::plural('Star', $filtered_article->reviews_avg_rating) }})</span>
                        </div>
                    </div>

                    <div class="row border-top py-3">
                        <div class="col-xl-3 col-md-3">
                            <div class="card-content">
                                <b class="d-block text-uppercase text-14">min read</b>
                                <span class="badge bg-primary ml-auto">{{ $filtered_article->min_read }}</span>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-3">
                            <div class="card-content">
                                <b class="d-block text-uppercase text-14">about</b>
                                <span>{{ $filtered_article->about }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row border-top py-3">
                        <h3>Reviews ({{ $filtered_article->reviews_count }})</h3>
                        <!--------------------Highest Ratings------------------->
                        <div class=" border-top py-3 border-bottom">
                            <div class=" d-flex align-items-center border-bottom mb-2 ">
                                <span class="fw-bold fs-5">Top (3) Highest Ratings:</span>
                                @for ($i = 0; $i < $filtered_article->highest_rating; $i++)
                                    <i class='bx bxs-star' style="color: #ffc700;"></i>
                                @endfor
                                <span>({{ $filtered_article->highest_rating }}
                                    {{ Str::plural('Star', $filtered_article->highest_rating) }})</span>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Rating</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($highest_ratings as $highest_rating)
                                        <tr>
                                            <td>{{ $highest_rating->name }}</td>
                                            <td>{{ $highest_rating->email }}</td>
                                            <td>{{ $highest_rating->rating }}/5
                                                {{ Str::plural('Star', $highest_rating->rating) }}</td>
                                            @php
                                                $formattedDate = $highest_rating->created_at->format('dS M Y g:i A');
                                            @endphp
                                            <td>{{ $formattedDate }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--------------------Lowest Ratings------------------->
                        <div class="border-top py-3 border-bottom">
                            <div class="d-flex align-items-center border-bottom mb-2">
                                <span class="fw-bold fs-5">Top (3) Lowest Ratings:</span>
                                @for ($i = 0; $i < $filtered_article->lowest_rating; $i++)
                                    <i class='bx bxs-star' style="color: #ffc700;"></i>
                                @endfor

                                <span>({{ $filtered_article->lowest_rating }}
                                    {{ Str::plural('Star', $filtered_article->lowest_rating) }})</span>

                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Rating</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lowest_ratings as $lowest_rating)
                                        <tr>
                                            <td>{{ $lowest_rating->name }}</td>
                                            <td>{{ $lowest_rating->email }}</td>
                                            <td>{{ $lowest_rating->rating }}/5
                                                {{ Str::plural('Star', $lowest_rating->rating) }}</td>
                                            @php
                                                $formattedDate = $lowest_rating->created_at->format('dS M Y g:i A');
                                            @endphp
                                            <td>{{ $formattedDate }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!---------------Latest Ratings------------------->
                        <div class="border-top py-3 border-bottom">
                            <div class="d-flex align-items-center border-bottom mb-2">
                                <span class="fw-bold fs-5">Top (5) Latest Ratings:</span>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Rating</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($latest_ratings as $latest_rating)
                                        <tr>
                                            <td>{{ $latest_rating->name }}</td>
                                            <td>{{ $latest_rating->email }}</td>
                                            <td>{{ $latest_rating->rating }}/5
                                                {{ Str::plural('Star', $latest_rating->rating) }}</td>
                                            @php
                                                $formattedDate = $latest_rating->created_at->format('dS M Y g:i A');
                                            @endphp
                                            <td>{{ $formattedDate }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function() {
            $('.select_two_articles').select2({
                placeholder: 'Select Article'
            }).val('{{ $filtered_article?->id }}').trigger('change');
        });
    </script>
@endpush
