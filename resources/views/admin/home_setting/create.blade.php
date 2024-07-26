@extends('layouts.master')
@section('title', 'Create Home Setting')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.home-settings.index') }}" model="Home Setting" item="Create"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.home-settings.store') }}" method="POST" enctype="multipart/form-data">

                    <x-form.row>
                        <x-form.input type="file" col="12" label="Logo" id="logo" name="logo"
                            alt="logo" accept="image/*" onchange="previewThumb(this,'featured-logothumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-logothumb" />
                    <x-form.row>
                        <x-form.input type="text" col="6" label="Title" id="title" name="title"
                            :req="true" value="{{ old('title') }}" />
                        <x-form.input type="text" col="6" label="Slug" id="slug" name="slug"
                            :req="true" value="{{ old('slug') }}" />
                    </x-form.row>

                    <x-form.row>
                        <x-form.input type="file" col="12" label="Image" id="image" name="image"
                            alt="image" accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" />
 
                    <x-form.textarea label="Description" id="description" name="description"
                        value="{{ old('description') }}" rows="5" cols="5" />

                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="'checked'" />

            </div>
        </div>


        <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i> Save</x-form.button>
        </x-form.wrapper>


    </div>
@endsection

@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\DestinationCategoryRequest') !!}
    @include('_helpers.logo_preview', ['name' => 'logo'])
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.slugify', ['title' => 'title'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
@endpush
