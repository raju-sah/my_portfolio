@extends('layouts.master')
@section('title', 'Article Review Notification')
@section('content')

    <div class="container-xxl">

        <x-breadcrumb listRoute="{{route('admin.reviews.index')}}" model="Review" item="Notification of"></x-breadcrumb>

        <div>
            <div class="card">
                <div class="card-body">
                    @include('admin.article_review.show')
                </div>
            </div>
        </div>
    </div>
@endsection
