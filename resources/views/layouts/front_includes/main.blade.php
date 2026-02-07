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
        // Register ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        // Parallax and Reveal Animation for Text
        document.addEventListener('DOMContentLoaded', function() {
            gsap.utils.toArray('.scroll-reveal-text').forEach(text => {
                gsap.to(text, {
                    backgroundSize: '100% 100%',
                    y: -150, // Parallax effect
                    ease: 'none',
                    scrollTrigger: {
                        trigger: text,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true,
                    }
                });
            });

            // Smoothing the transition between background and text colors using Scrub
            const updateAllSections = () => {
                const isLight = document.documentElement.getAttribute('data-theme') === 'light';
                
                // Clear existing triggers to avoid conflicts on theme switch
                ScrollTrigger.getAll().forEach(st => {
                    if (st.vars.id && st.vars.id.includes('theme-')) st.kill();
                });

                gsap.utils.toArray('.scroll-section').forEach((section, i) => {
                    const bg = isLight ? section.getAttribute('data-bg-light') : section.getAttribute('data-bg');
                    const text = isLight ? section.getAttribute('data-text-light') : section.getAttribute('data-text');
                    
                    if (!bg || !text) return;

                    // Faster scrub (0.5s lag instead of 1.5s) and better trigger points
                    gsap.to(['body', document.documentElement], {
                        backgroundColor: bg,
                        color: text,
                        '--bg-primary': bg,
                        '--text-heading': text,
                        '--text-body': text,
                        scrollTrigger: {
                            id: `theme-${i}`,
                            trigger: section,
                            start: 'top 65%', // Start transition when section is well into view
                            end: 'top 35%',   // End transition faster
                            scrub: 0.5,
                        }
                    });
                });
            };

            updateAllSections();

            // Watch for theme toggle changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                        updateAllSections();
                        ScrollTrigger.refresh();
                    }
                });
            });

            observer.observe(document.documentElement, { attributes: true });
        });

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
