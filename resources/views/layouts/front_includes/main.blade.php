@extends('layouts.front_master')

@section('content')
    @include('frontend.hero')
    @include('frontend.project.project_list')
    @include('frontend.experience')
    @include('frontend.skill')
    @include('frontend.article.home_article')
    @include('frontend.contact')
@endsection

@push('front_js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    @include('_helpers.country_dial_code', ['id' => 'phone'])

    <script>
        let storeRoute = "{{ route('contact.store') }}";
    </script>

    @include('_helpers.single_page_table_ajax', ['formId' => '#contact_form'])

    <script type="text/javascript">
        $(document).ready(function() {
            const btn_submit = $('.btn_submit');

            $('#contact_form').on('submit', function(e) {
                e.preventDefault();
                const pri_min = $('#pri_min').val();

                if (pri_min !== '') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Fake Content detected!',
                    }).then((result) => {
                        $('#contact_form')[0].reset();

                    });

                } else {
                    saveData();

                }
            });

            $(document).on('fetchEvent', function() {});

            $(document).on('click', '.btn_submit', function() {
                $('html, body').animate({
                    // scrollTop: '-=100px' // Scroll up by 100 pixels
                    scrollTop: $('#contact_form').offset().top - 60
                }, 'fast');
            });
        });
    </script>
@endpush
