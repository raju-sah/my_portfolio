@extends('layouts.master')
@section('title', 'Create Project')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.projects.index') }}" model="Project" item="Create"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    <x-form.row>
                        <x-form.input type="file" :req="true" label="Image" id="image" name="image"
                            alt="image" accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" . />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ old('name') }}" />
                        <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                            name="slug" value="{{ old('slug') }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" label="web_url" id="web_url" name="web_url"
                            value="{{ old('web_url') }}" />
                        <x-form.input type="text" col="6" label="github_url" id="github_url" name="github_url"
                            value="{{ old('github_url') }}" />
                    </x-form.row>
                    <x-form.row>
                    <x-form.input type="text" col="6" label="Year" :req="true" id="year"
                        name="year" value="{{ old('year') }}" />
                        
                        <x-form.input type="number" min="1" col="6" label="display order" :req="true" id="display_order"
                        name="display_order" value="{{ old('display_order') }}" />
                    </x-form.row>
                    <x-form.textarea label="Description" id="description" name="description"
                        value="{{ old('description') }}" rows="5" cols="5" />

                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="'checked'" />

                    <div class="d-flex" style="max-width: 45%">
                        <x-form.input type="text" :req="true" label="Tech_used" id="tech_used" name="tech_used[]"
                            placeholder="Tech Name" value="{{ old('tech_used[]') }}" />
                        <span class="ms-2  rajuspan btn btn-success js-add--field-row"
                            style="margin-top: 34px; height: 38.95px;"><i class="bx bx-plus">Add</i></span>
                    </div>

                    <div id="form-variations-list"></div>

                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save</x-form.button>
                </x-form.wrapper>



                <template id="template-form">
                    <div class="input-container d-flex mt-1" style="max-width: 50%;">

                        <input type="text" :req="true" name="tech_used[]" class="form-control ms-2 me-2"
                            placeholder="Tech Name" style="height: 38.95px;
      margin-top: 34px;">
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ProjectRequest') !!}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.slugify', ['title' => 'name'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
    @include('_helpers.repeater')
@endpush
