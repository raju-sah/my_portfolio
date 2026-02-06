@extends('layouts.master')
@section('title', 'Edit Skill')
@section('content')
<div class="container-xxl">

    <x-breadcrumb listRoute="{{ route('admin.skills.index') }}" model="Skill" item="Edit"></x-breadcrumb>

    <div class="card">
        <div class="card-body">

            <x-form.wrapper action="{{ route('admin.skills.update', $skill->id) }}" method="POST"
                enctype="multipart/form-data">
                @method('PATCH')
                <x-form.row>
                    <x-form.input type="text" col="6" :req="true" label="Name" id="name"
                        name="name" value="{{ $skill->name }}" />
                    <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                        name="slug" value="{{ $skill->slug }}" />
                </x-form.row>
                <x-form.row>
                    <x-form.input type="text" col="4" :req="true" label="percentage" id="percentage"
                        name="percentage" value="{{ $skill->percentage }}" />
                    <x-form.input type="number" col="4" :req="true" label="display_order" id="display_order"
                        name="display_order" value="{{ $skill->display_order }}" />
                    <x-form.enum-select :options="App\Enums\SkillDomain::cases()" col="4" :req="true" label="Skill Domain" id="skill_domain" name="skill_domain" :model="optional($skill->skill_domain)->value" />
                </x-form.row>
                <x-form.textarea label="Description" id="description" name="description"
                    value="{!! $skill->description !!}" rows="5" cols="5" />

                <x-form.checkbox label="Status" id="status" name="status" value="1" class="form-check-input"
                    isEditMode="yes" :isChecked="$skill->status ? 'checked' : ''" />

                <x-form.button class="btn btn-sm btn-dark" type="submit"><i class='bx bx-save bx-xs'></i>
                    Save</x-form.button>
            </x-form.wrapper>
        </div>
    </div>
</div>
@endsection
@push('custom_js')
{!! JsValidator::formRequest('App\Http\Requests\Admin\SkillUpdateRequest') !!}
@include('_helpers.image_preview', ['name' => 'image'])
@include('_helpers.slugify', ['title' => 'name'])
@include('_helpers.ck_editor', ['textarea_id' => 'description'])
@endpush