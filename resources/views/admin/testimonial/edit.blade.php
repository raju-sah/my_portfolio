@extends('layouts.master')
@section('title', 'Edit Testimonial')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.testimonials.index') }}" model="Testimonial" item="Edit"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PATCH')
                    <x-form.row>
                        <x-form.input type="file" label="Image" id="image" name="image" alt="image"
                            accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" . url="{{ $testimonial->image_path }}" />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ $testimonial->name }}" />
                        <x-form.input type="text" col="6" :req="true" label="email" id="email"
                            name="email" value="{{ $testimonial->email }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="position" id="position"
                            name="position" value="{{ $testimonial->position }}" />
                        <x-form.input type="text" col="6" :req="true" label="phone" id="phone"
                            name="phone" value="{{ $testimonial->phone }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="facebook_link"
                            id="facebook_link" name="facebook_link" value="{{ $testimonial->facebook_link }}" />
                        <x-form.input type="text" col="6" :req="true" label="instagram_link"
                            id="instagram_link" name="instagram_link" value="{{ $testimonial->instagram_link }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="linkedin_link"
                            id="linkedin_link" name="linkedin_link" value="{{ $testimonial->linkedin_link }}" />
                        <x-form.input type="text" col="6" :req="true" label="website_link" id="website_link"
                            name="website_link" value="{{ $testimonial->website_link }}" />
                    </x-form.row>


                    <x-form.input type="text" label="Github_link" id="github_link" name="github_link"
                        value="{{ $testimonial->github_link }}" />
                    <x-form.textarea label="Message" id="message" name="message" value="{!! $testimonial->message !!}"
                        rows="5" cols="5" />
                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="$testimonial->status ? 'checked' : ''" />

                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save</x-form.button>
                </x-form.wrapper>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\TestimonialUpdateRequest') !!}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.ck_editor', ['textarea_id' => 'message'])
@endpush
