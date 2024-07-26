@extends('layouts.master')
@section('title', 'Contact Notification')
@section('content')

    <div class="container-xxl">

        <x-breadcrumb listRoute="{{route('admin.contacts.index')}}" model="Contact" item="Notification of"></x-breadcrumb>

        <div>
            <div class="card">
                <div class="card-body">
                    @include('admin.contact.show')
                </div>
            </div>
        </div>
    </div>
@endsection
