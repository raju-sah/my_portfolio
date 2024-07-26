@extends('layouts.master')
@section('title', 'Edit Project')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.projects.index') }}" model="Project" item="Edit"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.projects.update', $project->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PATCH')

                    <x-form.row>
                        <x-form.input type="file" :req="true" label="Image" id="image" name="image"
                            alt="image" accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" . url="{{ $project->image_path }}" />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ $project->name }}" />
                        <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                            name="slug" value="{{ $project->slug }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="github_url" id="github_url"
                            name="github_url" value="{{ $project->github_url }}" />
                        <x-form.input type="text" col="6" :req="true" label="web_url" id="web_url"
                            name="web_url" value="{{ $project->web_url }}" />
                    </x-form.row>
                    <x-form.row>
                    <x-form.input type="text" col="6" label="Year" :req="true" id="year"
                        name="year" value="{{ $project->year }}" />

                    <x-form.input type="number" min="1" col="6" label="display order" :req="true"
                        id="display_order" name="display_order" value="{{ $project->display_order }}" />
                    </x-form.row>
                    <x-form.textarea label="Description" id="description" name="description" value="{!! $project->description !!}"
                        rows="5" cols="5" />

                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="$project->status ? 'checked' : ''" />
                    <span class="btn btn-sm btn-success js-add--field-row" style="margin-top: 34px;"><i
                            class="bx bx-xs bx-plus"></i>Add</span>
                    @php
                        $techs = json_decode($project->tech_used);
                    @endphp

                    @foreach ($techs as $key => $value)
                        <div class="input-container   d-flex" style="max-width: 45%">
                            <input type="text" :req="true" name="tech_used[]" required
                                value="{{ $value ?? '' }}" class="form-control ms-2 me-2"
                                style="height: 38.95px;
                               margin-top: 34px;"placeholder="Tech Name">
                            <button class="btn btn-danger btn-sm js-remove--field-row"
                                style="height: 38.95px;
          margin-top: 34px;"><i class="bx bx-xs bx-x"
                                    style="display: inline-block;"></i></button>
                        </div>
                    @endforeach

                    <div id="form-variations-list"></div>

                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save</x-form.button>
                </x-form.wrapper>

                <template id="template-form">
                    <div class="input-container d-flex mt-1" style="max-width: 45%;">
                        <input type="text" name="tech_used[]" :req="true" class="form-control ms-2 me-2"
                            placeholder="Tech Name" style="height: 38.95px; margin-top: 34px;">
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\ProjectUpdateRequest') !!} --}}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.slugify', ['title' => 'name'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
    @include('_helpers.repeater')
@endpush
