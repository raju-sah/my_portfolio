<section class="relative py-20 overflow-hidden testimonials">
  <div class="container mx-auto px-6 relative z-10">
    <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Testimonials</h4>
    
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="testimonialBox bg-card/60 backdrop-blur-md border border-white/5 rounded-2xl p-8 relative">
            <img src="Images/quotess.png" class="quote absolute top-6 right-6 w-16 h-16 opacity-20" />
            <div class="testcontent mb-6">
              <p class="text-body leading-relaxed">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Natus animi dolores doloremque assumenda commodi dicta at
                voluptas nostrum doloribus fugit magnam explicabo velit,
                architecto sit. Laboriosam modi eveniet debitis amet
              </p>
            </div>
            <div class="details flex items-center gap-4">
              <div class="imgbx w-14 h-14 rounded-full overflow-hidden border-2 border-accent/50">
                <img src="https://uxwing.com/wp-content/themes/uxwing/download/peoples-avatars/man-person-icon.png" alt="Avatar" class="w-full h-full object-cover" />
              </div>
              <div>
                <h3 class="text-heading font-semibold">Some One Famous</h3>
                <span class="text-accent text-sm">Team Lead</span>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonialBox bg-card/60 backdrop-blur-md border border-white/5 rounded-2xl p-8 relative">
            <img src="Images/quotess.png" class="quote absolute top-6 right-6 w-16 h-16 opacity-20" />
            <div class="testcontent mb-6">
              <p class="text-body leading-relaxed">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Natus animi dolores doloremque assumenda commodi dicta at
                voluptas nostrum doloribus fugit magnam explicabo velit,
                architecto sit. Laboriosam modi eveniet debitis amet
              </p>
            </div>
            <div class="details flex items-center gap-4">
              <div class="imgbx w-14 h-14 rounded-full overflow-hidden border-2 border-accent/50">
                <img src="https://uxwing.com/wp-content/themes/uxwing/download/peoples-avatars/man-person-icon.png" alt="Avatar" class="w-full h-full object-cover" />
              </div>
              <div>
                <h3 class="text-heading font-semibold">Some One Famous</h3>
                <span class="text-accent text-sm">Team Lead</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination mt-8"></div>
    </div>
  </div>
</section>

<style>
    .testimonials .swiper {
      width: 100%;
      padding-bottom: 50px;
    }

    .testimonials .swiper-slide {
      max-width: 400px;
      filter: blur(2px) brightness(0.7);
      transition: all 0.5s ease;
    }
    .testimonials .swiper-slide-active {
      filter: blur(0px) brightness(1);
      transform: scale(1.05);
    }

    .swiper-pagination .swiper-pagination-bullet {
      background: var(--text-body);
      width: 10px;
      height: 10px;
      margin: 0 5px;
      border-radius: 50%;
      cursor: pointer;
      opacity: 0.4;
    }
    .swiper-pagination .swiper-pagination-bullet-active {
      background: var(--accent-color); 
      opacity: 1;
    }
</style>

<script>
  var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: false,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 100,
      modifier: 2,
      slideShadows: false,
    },
    loop: false,
    speed: 1500,
    pagination: {
      el: ".swiper-pagination",
    },
    autoplay: {
      delay: 2500,
    }
  });
</script>
