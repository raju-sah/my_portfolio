<footer class="relative mt-20 pt-10 pb-10 border-t border-white/5 bg-black/40 backdrop-blur-lg">
    <div class="container mx-auto px-6 text-center">
        
        <!-- Social Icons -->
        <div class="flex justify-center flex-wrap gap-6 mb-8">
            @foreach ($social_links as $key => $social_link)
                <a href="mailto:{{ optional($social_link)->email }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-accent hover:border-accent transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-accent/40">
                    <i class="fa-solid fa-envelope text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->facebook_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-blue-600 hover:border-blue-600 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-blue-600/40">
                    <i class="fa-brands fa-facebook text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->insta_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-pink-600 hover:border-pink-600 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-pink-600/40">
                    <i class="fa-brands fa-square-instagram text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->twitter_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-sky-500 hover:border-sky-500 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-sky-500/40">
                    <i class="fa-brands fa-square-twitter text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->youtube_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-red-600 hover:border-red-600 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-red-600/40">
                    <i class="fa-brands fa-youtube text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->linkedin_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-blue-700 hover:border-blue-700 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-blue-700/40">
                    <i class="fa-brands fa-linkedin text-lg"></i>
                </a>
                <a href="{{ optional($social_link)->github_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-gray-800 hover:border-gray-800 transition-all duration-300 hover:-translate-y-1 shadow-lg shadow-black/20 hover:shadow-gray-800/40">
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
</style>
