@extends('layouts.master')
@section('title', 'Edit Background')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.backgrounds.index') }}" model="Background" item="Edit"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.backgrounds.update', $background->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PATCH')
                    <x-form.row>
                        <x-form.input type="file" label="Image" id="image" name="image" alt="image"
                            accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" . url="{{ $background->image_path }}" />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ $background->name }}" />
                        <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                            name="slug" value="{{ $background->slug }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="address" id="address"
                            name="address" value="{{ $background->address }}" />
                        <x-form.input type="text" col="6" :req="true" label="map_url" id="map_url"
                            name="map_url" value="{{ $background->map_url }}" />
                    </x-form.row>
                    <x-form.input type="text" col="6" :req="true" label="web_url" id="web_url"
                        name="web_url" value="{{ $background->web_url }}" />
                    <x-form.textarea label="Description" id="description" name="description"
                        value="{!! $background->description !!}" rows="5" cols="5" />

                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="$background->status ? 'checked' : ''" />

                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save</x-form.button>
                </x-form.wrapper>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\BackgroundUpdateRequest') !!}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
    @include('_helpers.slugify', ['title' => 'name'])
@endpush
