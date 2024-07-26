@extends('layouts.master')
@section('title', 'SMTP Settings')
@section('content')

    <div class="container-xxl">

        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
                @php
                    $home_setting = \App\Models\HomeSetting::first();
                @endphp
                <a class="nav-link" aria-current="page" href="{{ route('admin.home-settings.edit', $home_setting->id) }}">Home
                    Settings</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Social Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.smtp-settings.index') }}">SMTP Settings</a>
            </li>


        </ul>

        <div class="card">
            <div class="card-body">
                <x-form.wrapper
                    action="{{ isset($socialSettings) && isset($socialSettings->id) ? route('admin.social-settings.update', $socialSettings->id) : route('admin.social-settings.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @method('PUT')

                    <x-form.row>
                        <x-form.input type="text" col="4" :req="true" label="email" id="email"
                            name="email" value="{{ $socialSettings ? $socialSettings->email : '' }}" />

                        <x-form.input type="text" col="4" :req="true" label="phone" id="phone"
                            name="phone" value="{{ $socialSettings ? $socialSettings->phone : '' }}" />

                        <x-form.input type="text" col="4" label="Address" id="address" name="address"
                            value="{{ $socialSettings ? $socialSettings->address : '' }}" />

                    </x-form.row>

                    <x-form.row>

                        <x-form.input type="text" col="6" :req="true" label="facebook_url" id="facebook_url"
                            name="facebook_url" value="{{ $socialSettings ? $socialSettings->facebook_url : '' }}" />
                        <x-form.input type="text" col="6" :req="true" label="insta_url" id="insta_url"
                            name="insta_url" value="{{ $socialSettings ? $socialSettings->insta_url : '' }}" />
                    </x-form.row>

                    <x-form.row>

                        <x-form.input type="text" col="6" :req="true" label="github_url" id="github_url"
                            name="github_url" value="{{ $socialSettings ? $socialSettings->github_url : '' }}" />

                        <x-form.input type="text" col="6" :req="true" label="linkedin_url" id="linkedin_url"
                            name="linkedin_url" value="{{ $socialSettings ? $socialSettings->linkedin_url : '' }}" />
                    </x-form.row>

                    <x-form.row>
                        <x-form.input type="text" col="6" label="twitter_url" id="twitter_url" name="twitter_url"
                            value="{{ $socialSettings ? $socialSettings->twitter_url : '' }}" />

                        <x-form.input type="text" col="6" label="youtube_url" id="youtube_url" name="youtube_url"
                            value="{{ $socialSettings ? $socialSettings->youtube_url : '' }}" />

                    </x-form.row>

                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save
                    </x-form.button>

                </x-form.wrapper>
            </div>
        </div>
    </div>

@endsection

@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\SocialSettingUpdateRequest') !!}
@endpush
