@extends('layouts.master')
@section('title', 'Create Experience')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.experiences.index') }}" model="Experience" item="Create"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.experiences.store') }}" method="POST" enctype="multipart/form-data">
                    <x-form.row>
                        <x-form.input type="file" :req="true" label="Image" id="image" name="image" alt="image"
                            accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" . />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ old('name') }}" />
                        <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                            name="slug" value="{{ old('slug') }}" />
                    </x-form.row>
                    <x-form.row>

                        <x-form.input type="text" col="6" label="location" id="location" name="location"
                            value="{{ old('location') }}" />
                        <x-form.input type="text" col="6" :req="true" label="web_url" id="web_url"
                            name="web_url" value="{{ old('web_url') }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="date_from" id="date_from"
                            name="date_from" value="{{ old('date_from') }}" />

                        <x-form.input type="text" col="6" label="date_to" id="date_to" name="date_to"
                            value="{{ old('date_to') }}" style="display:{{ old('curently_here') ? 'none' : 'block' }};" />
                    </x-form.row>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exampleCheckbox" name="curently_here"
                            value="1" {{ old('curently_here') ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleCheckbox">
                            Currently Here
                        </label>
                    </div>

                    <x-form.row>
                        <x-form.input type="text" label="Role" :req="true" col="6" id="role" name="role"
                            value="{{ old('role') }}" />
                        <x-form.input type="number" col="6" min="1" :req="true" label="display_order"
                            id="display_order" name="display_order" value="{{ old('display_order') }}" />
                    </x-form.row>

                    <x-form.textarea label="Description" id="description" name="description"
                        value="{{ old('description') }}" rows="5" cols="5" />

                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="'checked'" />



                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save</x-form.button>
                </x-form.wrapper>

            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ExperienceRequest') !!}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.slugify', ['title' => 'name'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
    @include('_helpers.visibility_when_checked')
@endpush
