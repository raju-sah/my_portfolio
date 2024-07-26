@extends('layouts.master')
@section('title', 'Create Testimonial')
@section('content')

    <div class="container-xxl">

        <x-breadcrumb listRoute="{{route('admin.testimonials.index')}}" model="Testimonial" item="Create"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{route('admin.testimonials.store')}}" method="POST" enctype="multipart/form-data">
                    <x-form.row>
                        <x-form.input type="file" label="Image" id="image" name="image" alt="image" accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                      </x-form.row>
                      <x-form.preview id="featured-thumb" . />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ old('name') }}" />
                        <x-form.input type="text" col="6" :req="true" label="email" id="email"
                            name="email" value="{{ old('email') }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" label="position" id="position" name="position"
                            value="{{ old('position') }}" />
                        <x-form.input type="text" col="6" label="phone" id="phone" name="phone"
                            value="{{ old('phone') }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" label="linkedin_link" id="linkedin_link" name="linkedin_link"
                            value="{{ old('linkedin_link') }}" />
                        <x-form.input type="text" col="6" label="website_link" id="website_link" name="website_link"
                            value="{{ old('website_link') }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" label="facebook_link" id="facebook_link" name="facebook_link"
                            value="{{ old('facebook_link') }}" />
                        <x-form.input type="text" col="6" label="instagram_link" id="instagram_link" name="instagram_link"
                            value="{{ old('instagram_link') }}" />
                    </x-form.row>
                   
                        <x-form.input type="text" col="6" label="github_link" id="github_link" name="github_link"
                            value="{{ old('github_link') }}" />
                        
<x-form.textarea label="Message" id="message" name="message" value="{{ old('message') }}" rows="5" cols="5" />
<x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input" isEditMode="yes" :isChecked="'checked'"/>

                        <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i> Save</x-form.button>
                </x-form.wrapper>

            </div>
        </div>
    </div>

@endsection

@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\TestimonialRequest') !!}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.ck_editor', ['textarea_id' => 'message'])
    
@endpush
