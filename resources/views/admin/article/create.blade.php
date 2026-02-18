@extends('layouts.master')
@section('title', 'Create Article')
@section('content')
<div class="container-xxl">

    <x-breadcrumb listRoute="{{ route('admin.articles.index') }}" model="Article" item="Create"></x-breadcrumb>

    <div class="card">
        <div class="card-body">

            <x-form.wrapper action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
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
                    <x-form.input type="number" min="1" col="3" :req="true" label="display order" id="display_order"
                        name="display_order" value="{{ old('display_order') }}" />
                    <x-form.input type="number" min="1" col="3" :req="true" label="minute read" id="min_read"
                        name="min_read" value="{{ old('min_read') }}" />
                    <x-form.input type="text" col="6" :req="true" label="about" id="about"
                        name="about" value="{{ old('about') }}" />
                </x-form.row>
                <x-form.row>
                    <div class="col-md-6">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-select" required>
                            @foreach (\App\Enums\ArticleType::cases() as $type)
                            <option value="{{ $type->value }}"
                                {{ old('type', 'article') === $type->value ? 'selected' : '' }}>
                                {{ $type->label() }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </x-form.row>
                <x-form.textarea label="Description" :req="true" id="description" name="description"
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\ArticleRequest') !!}
@include('_helpers.image_preview', ['name' => 'image'])
@include('_helpers.ck_editor', ['textarea_id' => 'description'])
@include('_helpers.slugify', ['title' => 'name'])
@endpush