

<footer class="py-3">
      <br>
      <br>
      <br>
      <div class="  social-icons-at-footer">

        @foreach ($social_links as $key => $social_link)
            <a href="mailto:{{ optional($social_link)->email }}" target="_blank">
                <i class="fa-solid fa-envelope"></i>
            </a>
            <a href="{{ optional($social_link)->facebook_url }}" target="_blank">
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="{{ optional($social_link)->insta_url }}" target="_blank">
                <i class="fa-brands fa-square-instagram"></i>
            </a>
            <a href="{{ optional($social_link)->twitter_url }}" target="_blank">
                <i class="fa-brands fa-square-twitter"></i>
            </a>
            <a href="{{ optional($social_link)->youtube_url }}" target="_blank">
                <i class="fa-brands fa-youtube"></i>
            </a>
            <a href="{{ optional($social_link)->linkedin_url }}" target="_blank">
                <i class="fa-brands fa-linkedin"></i>
            </a>
            <a href="{{ optional($social_link)->github_url }}" target="_blank">
                <i class="fa-brands fa-github"></i>
            </a>
        @endforeach
    </div>
    <div class="copyright">
        <p>
            Copyright © {{ date('Y') }} Raju Sah. Made with
            <i class="fa-solid fa-heart"></i> by Raju Sah.
        </p>
    </div>

</footer>
