{{-- Tailwind CDN with Custom Config --}}
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class', // We'll add 'dark' class to html element for theme
        theme: {
            extend: {
                colors: {
                    // Theme-aware colors using CSS variables
                    primary: 'var(--bg-primary)',
                    card: 'var(--bg-card)',
                    heading: 'var(--text-heading)',
                    body: 'var(--text-body)',
                    accent: 'var(--accent-color)',
                    badge: 'var(--bg-badge)',
                },
                animation: {
                    'float-slow': 'float 6s ease-in-out infinite',
                    'spin-slow': 'spin 20s linear infinite',
                    'spin-reverse': 'spin-reverse 25s linear infinite',
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                },
                keyframes: {
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-20px)' },
                    },
                    'spin-reverse': {
                        from: { transform: 'rotate(360deg)' },
                        to: { transform: 'rotate(0deg)' },
                    }
                }
            }
        }
    }
</script>

{{-- Global Theme Transition CSS --}}
<style>
    /* Smooth theme transitions for ALL elements */
    *,
    *::before,
    *::after {
        transition: background-color 0.4s ease, 
                    color 0.3s ease, 
                    border-color 0.3s ease,
                    box-shadow 0.3s ease,
                    fill 0.3s ease,
                    stroke 0.3s ease;
    }

    /* Prevent transition on page load flash */
    html.no-transition *,
    html.no-transition *::before,
    html.no-transition *::after {
        transition: none !important;
    }

    /* Base HTML styling for theme */
    html {
        background-color: var(--bg-primary);
        color: var(--text-body);
    }
    
    body {
        background-color: var(--bg-primary) !important;
        min-height: 100vh;
    }

    /* Main content alignment to match nav padding */
    .container {
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
    }
    @media (min-width: 1280px) {
        .container {
            padding-left: 8% !important;
            padding-right: 8% !important;
        }
    }
    @media (min-width: 1536px) {
        .container {
            padding-left: 12% !important;
            padding-right: 12% !important;
        }
    }

    /* Fix for Tailwind text colors to use CSS variables */
    .text-heading { color: var(--text-heading) !important; }
    .text-body { color: var(--text-body) !important; }
    .text-accent { color: var(--accent-color) !important; }
    .bg-primary { background-color: var(--bg-primary) !important; }
    .bg-card { background-color: var(--bg-card) !important; }
    .bg-accent { background-color: var(--accent-color) !important; }
    .border-heading { border-color: var(--text-heading) !important; }
    .border-accent { border-color: var(--accent-color) !important; }
    .border-card { border-color: var(--bg-card) !important; }

    /* Alpha variants */
    .bg-card\/10 { background-color: color-mix(in srgb, var(--bg-card) 10%, transparent) !important; }
    .bg-card\/30 { background-color: color-mix(in srgb, var(--bg-card) 30%, transparent) !important; }
    .bg-card\/40 { background-color: color-mix(in srgb, var(--bg-card) 40%, transparent) !important; }
    .bg-card\/60 { background-color: color-mix(in srgb, var(--bg-card) 60%, transparent) !important; }
    .bg-accent\/5 { background-color: color-mix(in srgb, var(--accent-color) 5%, transparent) !important; }
    .bg-accent\/10 { background-color: color-mix(in srgb, var(--accent-color) 10%, transparent) !important; }
    .bg-accent\/20 { background-color: color-mix(in srgb, var(--accent-color) 20%, transparent) !important; }
    .border-heading\/20 { border-color: color-mix(in srgb, var(--text-heading) 20%, transparent) !important; }
    .border-accent\/20 { border-color: color-mix(in srgb, var(--accent-color) 20%, transparent) !important; }
    .border-accent\/50 { border-color: color-mix(in srgb, var(--accent-color) 50%, transparent) !important; }
    .text-body\/50 { color: color-mix(in srgb, var(--text-body) 50%, transparent) !important; }
    .text-body\/60 { color: color-mix(in srgb, var(--text-body) 60%, transparent) !important; }
    .text-body\/70 { color: color-mix(in srgb, var(--text-body) 70%, transparent) !important; }
    .text-body\/40 { color: color-mix(in srgb, var(--text-body) 40%, transparent) !important; }

    /* Theme-aware shadow */
    .shadow-theme {
        box-shadow: 0 10px 40px -10px var(--shadow-color);
    }

    /* Glassmorphism that works on both themes */
    .glass {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid color-mix(in srgb, var(--text-heading) 10%, transparent);
    }

    /* Light mode specific overrides for better contrast */
    [data-theme="light"] .bg-black\/20 {
        background-color: rgba(0, 0, 0, 0.05) !important;
    }
    [data-theme="light"] .bg-black\/30 {
        background-color: rgba(0, 0, 0, 0.08) !important;
    }
    [data-theme="light"] .border-white\/5 {
        border-color: rgba(0, 0, 0, 0.08) !important;
    }
    [data-theme="light"] .border-white\/10 {
        border-color: rgba(0, 0, 0, 0.1) !important;
    }
    [data-theme="light"] .bg-white\/5 {
        background-color: rgba(0, 0, 0, 0.03) !important;
    }
    [data-theme="light"] .hover\:bg-white\/5:hover {
        background-color: rgba(0, 0, 0, 0.05) !important;
    }

    /* Parallax layer theme adaptation */
    [data-theme="light"] .parallax-layer {
        opacity: 0.08 !important;
    }

    /* Fix footer backdrop in light mode */
    [data-theme="light"] footer {
        background: rgba(255, 255, 255, 0.7) !important;
        border-top-color: rgba(0, 0, 0, 0.05) !important;
    }

    /* Nav improvements */
    [data-theme="light"] nav {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
    }
</style>

{{-- Main Stylesheet --}}
<link rel="stylesheet" href="{{ asset('style.css') }}">

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,100&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- Bootstrap --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

{{-- Swiper --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@stack('front_css')
