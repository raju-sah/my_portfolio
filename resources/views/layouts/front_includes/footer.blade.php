<footer class="relative mt-20 pt-10 pb-10 border-t border-white/5 bg-black/40 backdrop-blur-lg">
    <div class="container mx-auto px-6 text-center">
        
        <!-- Social Icons -->
        <div class="flex justify-center flex-wrap gap-6 mb-8">
            @foreach ($social_links as $key => $social_link)
                <a href="mailto:{{ optional($social_link)->email }}" target="_blank" 
                   data-tooltip="📧 Slide into my inbox!"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-accent hover:border-accent transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-accent/40">
                    <i class="fa-solid fa-envelope text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->facebook_url }}" target="_blank" 
                   data-tooltip="👴 Yes, I still use this"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-blue-600 hover:border-blue-600 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-blue-600/40">
                    <i class="fa-brands fa-facebook text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->insta_url }}" target="_blank" 
                   data-tooltip="📸 My questionable photo choices"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-pink-600 hover:border-pink-600 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-pink-600/40">
                    <i class="fa-brands fa-square-instagram text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->twitter_url }}" target="_blank" 
                   data-tooltip="🐦 Hot takes & cold coffee"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-sky-500 hover:border-sky-500 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-sky-500/40">
                    <i class="fa-brands fa-square-twitter text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->youtube_url }}" target="_blank" 
                   data-tooltip="🎬 Subscribe or I'll cry"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-red-600 hover:border-red-600 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-red-600/40">
                    <i class="fa-brands fa-youtube text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->linkedin_url }}" target="_blank" 
                   data-tooltip="👔 Let's be professionally awkward"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-blue-700 hover:border-blue-700 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-blue-700/40">
                    <i class="fa-brands fa-linkedin text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->github_url }}" target="_blank" 
                   data-tooltip="🐙 Where bugs become features"
                   class="footer-tooltip w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-gray-800 hover:border-gray-800 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-gray-800/40">
                    <i class="fa-brands fa-github text-lg"></i>
                </a>
            @endforeach
        </div>

        <!-- Copyright -->
        <div class="text-gray-500 text-sm font-medium">
            <p>
                Copyright © {{ date('Y') }} Raju Sah. Made with
                <i class="fa-solid fa-heart text-red-500 mx-1 animate-pulse"></i> by Raju Sah.
            </p>
        </div>
    </div>
</footer>

<style>
    /* Custom utility for accent color hover until Tailwind config is updated completely */
    .hover\:bg-accent:hover {
        background-color: var(--accent-color, #cf3f36);
    }
    .hover\:border-accent:hover {
        border-color: var(--accent-color, #cf3f36);
    }
    .hover\:shadow-accent\/40:hover {
        box-shadow: 0 10px 15px -3px rgba(207, 63, 54, 0.4);
    }
    /* Tooltip styles for footer icons */
    .footer-tooltip {
        position: relative;
    }
    .footer-tooltip::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        padding: 8px 12px;
        background: rgba(25, 25, 30, 0.97);
        color: #ff6b5b;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        border-radius: 8px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1000;
        pointer-events: none;
        border: 1px solid rgba(207, 63, 54, 0.25);
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }
    .footer-tooltip:hover::before {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-12px);
    }
</style>
