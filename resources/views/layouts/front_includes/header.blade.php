<nav>

    <a href="{{ url('/') }}"><img src="{{ asset('uploaded-images/home-setting-images/' . $home_setting->image) }}"
            class="alllogo" height="100px" width="100px" /></a>
    <div class="nav-links" id="navLinks">
        <i class="fa fa-times" onclick="hideMenu()"></i>

        <ul class="menu-item justify-content-center align-items-center">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('projects.all') }}">Projects</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="{{ route('articles.all') }}">Articles</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>

{{-- -----------------------------Fixed Social Icons at sidebar --------------------------- --}}
<div class="icon-bar">
    @foreach ($social_links as $key => $social_link)
        <a href="mailto:{{ optional($social_link)->email }}" target="_blank" class="email"><i
                class="fa-solid fa-envelope" style="color: #000"></i></a>
        <a href="{{ optional($social_link)->linkedin_url }}" target="_blank" class="linkedin"><i
                class="fa-brands fa-linkedin" style="color: #000"></i></a>
        <a href="{{ optional($social_link)->insta_url }}" target="_blank" class="instagram"><i
                class="fa-brands fa-square-instagram" style="color: #000"></i></a>
        <a href="{{ optional($social_link)->facebook_url }}" target="_blank" class="facebook"><i
                class="fa-brands fa-facebook" style="color: #000"></i></a>
        <a href="{{ optional($social_link)->twitter_url }}" target="_blank" class="twitter"><i
                class="fa-brands fa-square-twitter" style="color: #000"></i></a>
        <a href="{{ optional($social_link)->youtube_url }}" target="_blank" class="youtube"><i
                class="fa-brands fa-youtube" style="color: #000"></i></a>
        <a href="{{ optional($social_link)->github_url }}" target="_blank" class="github"><i
                class="fa-brands fa-github" style="color: #000"></i></a>
    @endforeach
</div>

{{---------------- javascript  for responsive navbar ---------------}}
<script>
    var navLinks = document.getElementById("navLinks");

    function showMenu() {
        navLinks.style.right = "0";
        navLinks.style.padding = "0 100px 0 0";
        navLinks.style.transition = "all 0.5s";
        navLinks.style.display = "flex";
        navLinks.style.flexDirection = "column";
    }

    function hideMenu() {
        console.log("Hiding menu...");
        navLinks.style.display = "none";
    }
</script>
