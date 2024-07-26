<section class="testimonials">
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="testimonialBox">
          <img src="Images/quotess.png" class="quote" />
          <div class="testcontent">
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Natus animi dolores doloremque assumenda commodi dicta at
              voluptas nostrum doloribus fugit magnam explicabo velit,
              architecto sit. Laboriosam modi eveniet debitis amet
            </p>
          </div>
          <div class="details">
            <div class="imgbx">
              <img src="https://uxwing.com/wp-content/themes/uxwing/download/peoples-avatars/man-person-icon.png" alt="Bootstrap logo" />
            </div>
            <h3>Some One Famous<br /><span>Team Lead</span></h3>

            <div class="contents">
              <div class="links d-flex justify-content-center">
                <a href="#" target="_blank"
                  ><i class="fab fa-github-square"></i
                ></a>
                <a href="#" target="_blank"
                  ><i class="fas fa-link"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="testimonialBox">
          <img src="Images/quotess.png" class="quote" />
          <div class="testcontent">
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Natus animi dolores doloremque assumenda commodi dicta at
              voluptas nostrum doloribus fugit magnam explicabo velit,
              architecto sit. Laboriosam modi eveniet debitis amet
            </p>
          </div>
          <div class="details">
            <div class="imgbx">
              <img src="https://uxwing.com/wp-content/themes/uxwing/download/peoples-avatars/man-person-icon.png" alt="Bootstrap logo" />
            </div>
            <h3>Some One Famous<br /><span>Team Lead</span></h3>
            <div class="contents">
              <div class="links d-flex justify-content-center">
                <a href="#" target="_blank"
                  ><i class="fab fa-github-square"></i
                ></a>
                <a href="#" target="_blank"
                  ><i class="fas fa-link"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
  </div>
  

  <style>
      
      .testimonials {
      position: relative;
      width: 100%;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #111;
      overflow: hidden;
    }

    .swiper {
      width: 100%;
    }

    .swiper-slide {
      overflow: hidden;
      background-position: center;
      height: 100%;
      max-height: 450px;
      width: 100%;
      max-width: 350px;
      background: #000;
      border-radius: 10px;
      filter: blur(4px);
      margin-bottom: 50px;
    }
    .swiper-slide-active {
      filter: blur(0px);
    }
    .testimonialBox {
      position: relative;
      padding: 40px;
      padding-top: 90px;
      margin: 0 30px;
      background: #000;
      color: #fff;
    }
    .testimonialBox .quote {
      position: absolute;
      top: 20px;
      right: 30px;
      opacity: 0.4;
      width: 80px;
      height: 80px;
    }

    .testimonialBox .testcontent p {
      color: lightslategray;
    }

    .testimonialBox .details {
     
      display: flex;
      margin-top: 20px;
      align-items: center;
    }

    .testimonialBox .details .imgbx {
      position: relative;
      width: 60px;
      height: 60px;
      overflow: hidden;
      border-radius: 50%;
      margin-right: 10px;
    }

    .testimonialBox .details .imgbx img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .testimonialBox .details h3 {
      font-size: 16px;
      font-weight: 400;
      letter-spacing: 1px;
      color: #2196f3;
      line-height: 1.1em;
    }
    .testimonialBox .details h3 span {
      font-size: 14px;
      color: #666;
    }

    .mySwiper-3d .swiper-slide-shadow-left,
    .mySwiper-3d .swiper-slide-shadow-right {
      background-image: none;
    }

    .contents {
      position: absolute;
      bottom: -250px;
      left: 10px;
      color: #fff;
      transition: all 0.5s ease-in-out;
    }

    .swiper-slide:hover .contents {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 1000px !important;
      width: 500px !important;
      backdrop-filter: blur(10px);
    }
    .links {
      margin-right: 230px !important;
    }
    .links i {
      margin: 0 10px;
      font-size: 50px;
      color: #ff004f;
    }

    .links i:hover {
      translate: 0 -5px;
      transition: all 0.5s;
      color: #000;
    }

  .swiper-pagination .swiper-pagination-bullet {
    background: #fff;
    width: 10px;
    height: 10px;
    margin: 0 5px;
    border-radius: 50%;
    cursor: pointer;
  }
  .swiper-pagination .swiper-pagination-bullet-active {
    background: #ff004f; 
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
      slideShadows: true,
    },
    loop: false,
    speed:1500,
    pagination: {
      el: ".swiper-pagination",
    },
    autoplay: {
      delay: 2500,
    }
  });
</script>
</section>

