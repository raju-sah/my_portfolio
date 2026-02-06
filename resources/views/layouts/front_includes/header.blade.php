<nav class="sticky top-0 z-50 backdrop-blur-md border-b border-white/5">
    <a href="{{ url('/') }}"><img src="{{ asset('uploaded-images/home-setting-logo/' . $home_setting->logo) }}"
            class="alllogo" /></a>
    <div class="nav-links" id="navLinks">
        <i class="fa fa-times" onclick="hideMenu()"></i>

        <ul class="menu-item justify-content-center align-items-center">
            <li class="nav-tooltip-wrap" data-tooltip="🏠 where the magic begins!">
                <a href="{{ url('/') }}">Home</a>
            </li>
            @if(request()->routeIs('index'))
            <li class="nav-tooltip-wrap" data-tooltip="⚡ My superpowers (AI helped)">
                <a href="#skills">Skills</a>
            </li>
            @endif
            <li class="nav-tooltip-wrap" data-tooltip="💻 Proof I don't just binge Netflix all day">
                <a href="{{ route('projects.all') }}">Projects</a>
            </li>
            <li class="nav-tooltip-wrap" data-tooltip="📝 My thoughts... at 3 AM with coffee">
                <a href="{{ route('articles.all') }}">Articles</a>
            </li>
            <li class="nav-tooltip-wrap valentine-menu-item {{ request()->routeIs('valentine.*') ? 'active' : '' }}" id="valentineNavItem" data-tooltip="💕 Find your Valentine... maybe?">
                <a href="{{ route('valentine.index') }}">Valentine</a>
            </li>
            @if(request()->routeIs('index'))
            <li class="nav-tooltip-wrap" data-tooltip="👋 Say hi! I don't bite (much)">
                <a href="#contact">Contact</a>
            </li>
            @endif
        </ul>
        
        {{-- Enhanced Theme Toggle Button --}}
        <button class="theme-toggle group nav-tooltip-wrap" data-tooltip="🌓 Embrace the dark side... or don't" onclick="toggleTheme()" aria-label="Toggle theme">
            <span class="relative w-10 h-10 flex items-center justify-center rounded-full bg-card border border-white/10 hover:border-accent/50 transition-all duration-300 hover:scale-110 group-hover:shadow-lg group-hover:shadow-accent/20">
                <i class="fa-solid fa-sun theme-icon-sun absolute transition-all duration-300" id="theme-icon-sun"></i>
                <i class="fa-solid fa-moon theme-icon-moon absolute transition-all duration-300 opacity-0 scale-50 rotate-90" id="theme-icon-moon"></i>
            </span>
        </button>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>

{{-- Fixed Social Icons at sidebar --}}
<div class="icon-bar">
    @foreach ($social_links as $key => $social_link)
        <a href="mailto:{{ optional($social_link)->email }}" target="_blank" class="social-icon email" data-tooltip="📧 Slide into my inbox!"><i class="fa-solid fa-envelope"></i></a>
        <a href="{{ optional($social_link)->linkedin_url }}" target="_blank" class="social-icon linkedin" data-tooltip="👔 Let's be professionally awkward"><i class="fa-brands fa-linkedin"></i></a>
        <a href="{{ optional($social_link)->insta_url }}" target="_blank" class="social-icon instagram" data-tooltip="📸 My questionable photo choices"><i class="fa-brands fa-square-instagram"></i></a>
        <a href="{{ optional($social_link)->facebook_url }}" target="_blank" class="social-icon facebook" data-tooltip="👴 Yes, I still use this"><i class="fa-brands fa-facebook"></i></a>
        <a href="{{ optional($social_link)->twitter_url }}" target="_blank" class="social-icon twitter" data-tooltip="🐦 Hot takes & cold coffee"><i class="fa-brands fa-square-twitter"></i></a>
        <a href="{{ optional($social_link)->youtube_url }}" target="_blank" class="social-icon youtube" data-tooltip="🎬 Subscribe or I'll cry"><i class="fa-brands fa-youtube"></i></a>
        <a href="{{ optional($social_link)->github_url }}" target="_blank" class="social-icon github" data-tooltip="🐙 Where bugs become features"><i class="fa-brands fa-github"></i></a>
    @endforeach
</div>

<style>
    /* Custom Sarcastic Tooltips */
    .nav-tooltip-wrap {
        position: relative;
    }
    .nav-tooltip-wrap::before {
        content: attr(data-tooltip);
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(8px);
        padding: 10px 16px;
        background: rgba(25, 25, 30, 0.97);
        color: #ff6b5b;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        border-radius: 10px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1000;
        pointer-events: none;
        border: 1px solid rgba(207, 63, 54, 0.25);
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }
    .nav-tooltip-wrap::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-bottom-color: rgba(25, 25, 30, 0.97);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1001;
    }
    .nav-tooltip-wrap:hover::before,
    .nav-tooltip-wrap:hover::after {
        opacity: 1;
        visibility: visible;
    }
    .nav-tooltip-wrap:hover::before {
        transform: translateX(-50%) translateY(12px);
    }
    .nav-tooltip-wrap:hover::after {
        transform: translateX(-50%) translateY(2px);
    }

    /* Active Tooltip for Valentine only */
    #valentineNavItem::before,
    #valentineNavItem::after {
        opacity: 1;
        visibility: visible;
    }
    #valentineNavItem::before {
        transform: translateX(-50%) translateY(12px);
        animation: tooltipFloat 2s infinite ease-in-out;
    }
    #valentineNavItem::after {
        transform: translateX(-50%) translateY(2px);
    }

    @keyframes tooltipFloat {
        0%, 100% { transform: translateX(-50%) translateY(12px); }
        50% { transform: translateX(-50%) translateY(8px); }
    }

    /* Social icon tooltips - positioned to the right */
    .icon-bar .social-icon {
        position: relative;
    }
    .icon-bar .social-icon::before {
        content: attr(data-tooltip);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%) translateX(8px);
        padding: 8px 12px;
        background: rgba(25, 25, 30, 0.97);
        color: #ff6b5b;
        font-size: 12px;
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
    .icon-bar .social-icon:hover::before {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(12px);
    }

    /* Enhanced Icon Bar */
    .icon-bar .social-icon {
        display: block;
        padding: 8px;
        margin: 4px 0;
        color: var(--text-body);
        transition: all 0.3s ease;
        border-radius: 50%;
    }
    .icon-bar .social-icon:hover {
        color: #fff;
        transform: scale(1.2);
    }
    .icon-bar .social-icon.email:hover { background: linear-gradient(135deg, #ea4335, #fbbc05); }
    .icon-bar .social-icon.linkedin:hover { background: #0077b5; }
    .icon-bar .social-icon.instagram:hover { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .icon-bar .social-icon.facebook:hover { background: #1877f2; }
    .icon-bar .social-icon.twitter:hover { background: #1da1f2; }
    .icon-bar .social-icon.youtube:hover { background: #ff0000; }
    .icon-bar .social-icon.github:hover { background: #333; }

    /* Theme Toggle Styles */
    .theme-toggle {
        background: none;
        border: none;
        padding: 0;
        margin-left: 1rem;
        cursor: pointer;
    }
    [data-theme="light"] .theme-icon-sun {
        opacity: 0;
        transform: scale(0.5) rotate(-90deg);
    }
    [data-theme="light"] .theme-icon-moon {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }

    /* Valentine Special Nav Style */
    .valentine-menu-item.active a {
        color: #ff4d6d !important;
        text-shadow: 0 0 10px rgba(255, 77, 109, 0.5);
    }

    .nav-particle {
        position: absolute;
        pointer-events: none;
        font-size: 1.2rem;
        z-index: 1000;
        animation: particleFly 3s ease-out forwards;
    }

    @keyframes particleFly {
        0% { transform: translate(0, 0) scale(1); opacity: 1; }
        100% { transform: translate(var(--tx), var(--ty)) scale(0) rotate(var(--rot)); opacity: 0; }
    }
</style>

<script>
    var navLinks = document.getElementById("navLinks");
    var sunIcon = document.getElementById('theme-icon-sun');
    var moonIcon = document.getElementById('theme-icon-moon');
    
    // Prevent FOUC - add no-transition class initially
    document.documentElement.classList.add('no-transition');
    
    // Check local storage for theme and apply immediately
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'light') {
        document.documentElement.setAttribute('data-theme', 'light');
    } else {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
    
    // Remove no-transition class after a short delay
    setTimeout(() => {
        document.documentElement.classList.remove('no-transition');
    }, 100);

    function toggleTheme() {
        const theme = document.documentElement.getAttribute('data-theme');
        if (theme === 'light') {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        }
    }

    function showMenu() {
        navLinks.style.right = "0";
    }

    function hideMenu() {
        navLinks.style.right = "-280px";
    }

    // Valentine Nav Enhancements
    document.addEventListener('DOMContentLoaded', function() {
        let valNav = document.getElementById('valentineNavItem');
        
        // Fallback: Find by text if ID is missing (e.g. production cache)
        if (!valNav) {
            const allLinks = document.querySelectorAll('nav a');
            for (const link of allLinks) {
                if (link.textContent.toLowerCase().includes('valentine')) {
                    valNav = link.closest('li') || link; 
                    valNav.id = 'valentineNavItem';
                    break;
                }
            }
        }

        if (!valNav) return;

        // Tooltip Rotation
        const rizzMessages = [
            "💕 Slay! It's giving soulmate energy 💅",
            "💍 manifesting a main character moment ✨",
            "🍫 snack or sniped? find out here 🏹",
            "🧸 warning: high risk of falling in love ⚠️",
            "💋 rizz level: absolutely illegal 👑"
        ];
        let msgIndex = 0;

        // Ensure initial tooltip if missing
        if (!valNav.hasAttribute('data-tooltip')) {
            valNav.setAttribute('data-tooltip', rizzMessages[0]);
        }

        setInterval(() => {
            msgIndex = (msgIndex + 1) % rizzMessages.length;
            valNav.setAttribute('data-tooltip', rizzMessages[msgIndex]);
        }, 5000);

        // Infinite Burst
        const emojis = ['🌹', '🍫', '❤️', '💖', '🧸', '💋', '🤗', '💍'];
        
        function burstEmoji() {
            const rect = valNav.getBoundingClientRect();
            // Don't burst if not visible or zero size
            if (rect.width === 0) return;

            const emoji = document.createElement('div');
            emoji.className = 'nav-particle';
            emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            
            const startX = rect.left + Math.random() * rect.width;
            const startY = rect.top + Math.random() * rect.height;
            
            const angle = Math.random() * Math.PI * 2;
            const dist = 30 + Math.random() * 70;
            const tx = Math.cos(angle) * dist;
            const ty = Math.sin(angle) * dist;
            const rot = (Math.random() - 0.5) * 360;

            emoji.style.left = startX + 'px';
            emoji.style.top = startY + 'px';
            emoji.style.setProperty('--tx', `${tx}px`);
            emoji.style.setProperty('--ty', `${ty}px`);
            emoji.style.setProperty('--rot', `${rot}deg`);

            document.body.appendChild(emoji);
            setTimeout(() => emoji.remove(), 3000);
        }

        setInterval(burstEmoji, 400); // Constant stream of love
    });
</script>
