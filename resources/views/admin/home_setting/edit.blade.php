@extends('layouts.master')
@section('title', 'Home Settings')
@section('content')

    <div class="container-xxl">

        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Home Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.social-settings.index')}}">Social Setings</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.smtp-settings.index')}}">SMTP Setings</a>
            </li>

        </ul>



        <div class="tab-content">

            <div class=" tab-pane container active card" id="home">
                <div class="card">
                    <div class="card-body">

                        <x-form.wrapper action="{{ route('admin.home-settings.update', $homeSetting->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            <x-form.row>
                                <x-form.input type="file" col="6" label="Logo" id="logo" name="logo"
                                    alt="logo" accept="image/*" onchange="previewThumb(this,'featured-logothumb')" />
                            </x-form.row>

                            <x-form.preview id="featured-logothumb" url="{{ $homeSetting->logo_path }}" />
                            <x-form.row>
                                <x-form.input type="text" col="6" :req="true" label="Title" id="title"
                                    name="title" value="{{ $homeSetting->title }}" />
                                <x-form.input type="text" col="6" :req="true" label="Slug" id="slug"
                                    name="slug" value="{{ $homeSetting->slug }}" />
                            </x-form.row>

                            <x-form.row>
                                <x-form.input type="file" col="6" :req="true" label="favicon" id="image" name="image"
                                    alt="image" accept="image/*" onchange="previewThumb(this,'featured-thumb')" />
                            </x-form.row>

                            <x-form.preview id="featured-thumb" url="{{ $homeSetting->image_path }}" />


                            <x-form.row>
                                <x-form.input type="file" col="6" :req="true" label="PDF File"
                                    id="pdf_file" name="pdf_file" accept=".pdf" />
                            </x-form.row>

                            <div id="pdf-logo">
                                {!! $homeSetting->pdf_path
                                    ? '<img src="' .
                                        asset('images/pdf-icon.png') .
                                        '"alt="PDF Logo" style="width: 100px; height: 100px;" id="pdf-logo">'
                                    : '' !!}
                            </div>
                            <div id="pdf-name">{{ $homeSetting->pdf_file }}</div>

                            <style>
                                #pdf-name {
                                    margin-top: 10px;
                                    font-weight: bold;
                                }
                            </style>

                            <script>
                                document.getElementById('pdf_file').addEventListener('change', function(event) {
                                    const fileInput = event.target;
                                    const pdfLogoContainer = document.getElementById('pdf-logo');
                                    const pdfNameContainer = document.getElementById('pdf-name');

                                    if (fileInput.files && fileInput.files[0]) {
                                        const fileReader = new FileReader();

                                        fileReader.onload = function(e) {
                                            // Update the source of the <img> tag with the PDF icon
                                            pdfLogoContainer.querySelector('img').src = "{{ asset('images/pdf-icon.png') }}";
                                            pdfLogoContainer.querySelector('img').style.width = "100px";
                                            pdfLogoContainer.querySelector('img').style.height = "100px";

                                            // Display the name of the PDF
                                            pdfNameContainer.textContent = fileInput.files[0].name;

                                            // Make the img tag visible
                                            pdfLogoContainer.querySelector('img').style.display = 'block';
                                        };

                                        fileReader.readAsDataURL(fileInput.files[0]);
                                    }
                                });
                            </script>

                            <x-form.textarea label="Description" id="description" name="description"
                                value="{!! $homeSetting->description !!}" rows="5" cols="5" />

                            <x-form.checkbox label="Status" id="status" name="status" value="1"
                                class="form-check-input" isEditMode="yes" :isChecked="$homeSetting->status ? 'checked' : ''" />

                            <div id="inputContainer">

                                <label class="form-label mt-3">Back And Forth Text</label>
                                <br>
                                <span class="  rajuspan btn btn-success mt-2 mb-2" onclick="addInputFields()"><i
                                    class="bx bx-plus">Add</i></span>

                                <div class="input-container">
                                    @foreach ($homeSetting->BackForthTexts as $key => $value)
                                        <div class="d-flex mt-2">
                                            <input type="text" name="name[]" class="form-control me-2 w-50"
                                                value="{{ $value->name }}" placeholder="Enter name">
                                            <span class="  rajuspan btn btn-danger"
                                                onclick="removeInputFields(this)"><i class="bx bx-trash"></i></span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
            
                            <x-form.button class="btn btn-sm btn-dark mt-2" type="submit"><i class='bx bx-save bx-xs'></i>
                                Save</x-form.button>
                            </x-form.wrapper>
                          
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('custom_js')
    {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\HomeSettingUpdateRequest') !!} --}}
    @include('_helpers.slugify', ['title' => 'title'])
    @include('_helpers.ck_editor', ['textarea_id' => 'description'])
    @include('_helpers.image_preview', ['name' => 'image'])
    @include('_helpers.logo_preview', ['name' => 'logo'])
    @include('_helpers.multi_inputfield_addon')


    {{----------------the below code is here for the next button---------------------------------}}

    {{-- <span class="btn btn-primary mt-1 " onclick="showTab('menu1')">Next<i
        class='bx bx-right-arrow-alt '></i></span>
<script>
    function showTab(tabId) {
        var tab = new bootstrap.Tab(document.querySelector(`[href="#${tabId}"]`));
        tab.show();
    }
</script> --}}

@endpush
