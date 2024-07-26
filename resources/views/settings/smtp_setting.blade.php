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
                <a class="nav-link" href="{{ route('admin.social-settings.index') }}">Social Settings</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">SMTP Settings</a>
            </li>
        </ul>

        <div class="card">
            <div class="card-body">
                <x-form.wrapper
                    action="{{ isset($smtpSettings) && isset($smtpSettings->id) ? route('admin.smtp-settings.update', $smtpSettings->id) : route('admin.smtp-settings.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @method('PUT')

                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="mail mailer" id="mail_mailer"
                            name="mail_mailer" value="{{ $smtpSettings ? $smtpSettings->mail_mailer : '' }}" />

                        <x-form.input type="text" col="6" :req="true" label="mail_host" id="mail_host"
                            name="mail_host" value="{{ $smtpSettings ? $smtpSettings->mail_host : '' }}" />
                    </x-form.row>

                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="mail_port" id="mail_port"
                            name="mail_port" value="{{ $smtpSettings ? $smtpSettings->mail_port : '' }}" />

                        <x-form.input type="text" col="6" :req="true" label="mail_encryption"
                            id="mail_encryption" name="mail_encryption"
                            value="{{ $smtpSettings ? $smtpSettings->mail_encryption : '' }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="mail_username"
                            id="mail_username" name="mail_username"
                            value="{{ $smtpSettings ? $smtpSettings->mail_username : '' }}" />
                        <x-form.password col="6" :req="true" label="mail_password"
                            id="mail_password" name="mail_password"
                            value="{{ $smtpSettings ? $smtpSettings->mail_password : '' }}" />
                    </x-form.row>

                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="mail_from_address"
                            id="mail_from_address" name="mail_from_address"
                            value="{{ $smtpSettings ? $smtpSettings->mail_from_address : '' }}" />

                        <x-form.input type="text" col="6" :req="true" label="mail_from_name"
                            id="mail_from_name" name="mail_from_name"
                            value="{{ $smtpSettings ? $smtpSettings->mail_from_name : '' }}" />
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\SmtpSettingUpdateRequest') !!}
@endpush
