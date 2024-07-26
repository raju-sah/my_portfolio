<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
{{-- ------------------------- Swiper ----------------------------------- --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

{{-- ------------------------------------intlTelInput JS is a telephone input---------------------------------- --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<!------------------------------ Date Picker ------------------------------------>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!------------------------------ Select 2 ------------------------------------>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

@if (Session::has('success') || Session::has('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            timer: 6000,
            timerProgressBar: true,
            icon: '{{ session('success') ? 'success' : 'error' }}',
            title: '{{ session('success') ?? session('error') }}',
            showConfirmButton: false,
        })
    </script>
@endif

@stack('front_js')
