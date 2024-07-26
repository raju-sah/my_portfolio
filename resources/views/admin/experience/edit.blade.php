@extends('layouts.master')
@section('title', 'Edit Experience')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb listRoute="{{ route('admin.experiences.index') }}" model="Experience" item="Edit"></x-breadcrumb>

        <div class="card">
            <div class="card-body">

                <x-form.wrapper action="{{ route('admin.experiences.update', $experience->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PATCH')
                    <x-form.row>
                        <x-form.input type="file" label="Image" id="image" name="image" alt="image"
                            accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                    </x-form.row>
                    <x-form.preview id="featured-thumb" . url="{{ $experience->image_path }}" />
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                            name="name" value="{{ $experience->name }}" />
                        <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                            name="slug" value="{{ $experience->slug }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="location" id="location"
                            name="location" value="{{ $experience->location }}" />
                        <x-form.input type="text" col="6" :req="true" label="web_url" id="web_url"
                            name="web_url" value="{{ $experience->web_url }}" />
                    </x-form.row>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="date_from" id="date_from"
                            name="date_from" value="{{ $experience->date_from }}" />
                        <x-form.input type="text" col="6" :req="true" label="date_to" id="date_to"
                            name="date_to" value="{{ $experience->date_to }}" />

                    </x-form.row>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exampleCheckbox" name="curently_here"
                            value="1" {{ $experience->curently_here ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleCheckbox">
                            Currently Here
                        </label>
                    </div>
                    <x-form.row>
                        <x-form.input type="text" col="6" :req="true" label="role" id="role"
                            name="role" value="{{ $experience->role }}" />

                        <x-form.input type="number" col="6" min="1" :req="true" 
                            label="display_order" id="display_order" name="display_order"
                            value="{{ $experience->display_order }}" />

                    </x-form.row>
                    <x-form.textarea label="Description" id="description" name="description" value="{!! $experience->description !!}"
                        rows="5" cols="5" />

                    <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                        isEditMode="yes" :isChecked="$experience->status ? 'checked' : ''" />


                    <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                        Save</x-form.button>
                </x-form.wrapper>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ExperienceUpdateRequest') !!}
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
    @include('_helpers.slugify', ['title' => 'name'])
    @include('_helpers.visibility_when_checked')
@endpush
