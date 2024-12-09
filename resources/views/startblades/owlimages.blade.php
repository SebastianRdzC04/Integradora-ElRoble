<style>
  /* Estilos específicos para el carrusel de videos */
  #video-packages-carousel {
    padding: 4rem 0;
  }

  .video-packages-slider {
    height: 60rem;
    padding: 2rem 0;
  }

  .video-packages-slide {
    width: 37rem;
    height: 42rem;
    position: relative;
  }

  .video-packages-slide-container {
    width: 100%;
    height: 500px;
    border-radius: 1rem;
    overflow: hidden;
  }

  .video-packages-slide-container video {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .video-packages-slide-content {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
  }

  .video-packages-slide-content .package-price {
    position: absolute;
    top: 2rem;
    right: 2rem;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 0.5rem 1rem;
    border-radius: 1rem;
  }

  .video-packages-slide-content-bottom {
    position: absolute;
    margin-right: 1rem !important;
    bottom: 2rem;
    left: 1rem;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 1rem;
    border-radius: 1rem;
  }

  .video-packages-slider-control {
    display: flex;
    justify-content: center;
    position: relative;
    bottom: 2rem;
  }

  .video-packages-slider-arrow {
    background: white;
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 1rem;
    cursor: pointer;
    box-shadow: 0px 8px 24px rgba(18, 28, 53, 0.1);
  }

  .video-packages-slider-arrow ion-icon {
    font-size: 2rem;
    color: #222224;
  }

  .video-packages-slider .swiper-pagination-bullet {
    background: #ccc;
  }

  .video-packages-slider .swiper-pagination-bullet-active {
    background: #ec994b;
  }
</style>

<section id="video-packages-carousel" style="mask-image: linear-gradient(to top, #000000 91%, #91ef0400); background-color: antiquewhite;">
  <div class="container">
    <h3 class="text-center section-subheading"></h3>
    <h1 class="text-center section-heading"> Alberca y Salon de Eventos</h1>
  </div>
  <div class="container">
    <div class="swiper video-packages-slider">
      <div class="swiper-wrapper">
        <!-- Video Slide 1 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/alberca.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$99.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Aventura</h2>
              <h3 class="package-description">Explora la naturaleza con nuestro paquete de aventuras</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 2 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/barra.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$149.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Relax</h2>
              <h3 class="package-description">Disfruta de un día de spa y relajación total</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 3 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/barrayvino.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$199.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Gastronómico</h2>
              <h3 class="package-description">Explora los mejores sabores de la ciudad</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 4 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/barrayvino.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$199.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Gastronómico</h2>
              <h3 class="package-description">Explora los mejores sabores de la ciudad</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 5 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/cascada.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$199.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Gastronómico</h2>
              <h3 class="package-description">Explora los mejores sabores de la ciudad</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 6 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/globosgirando.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$199.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Gastronómico</h2>
              <h3 class="package-description">Explora los mejores sabores de la ciudad</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 7 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/salonymesas.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$199.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Gastronómico</h2>
              <h3 class="package-description">Explora los mejores sabores de la ciudad</h3>
            </div>
          </div>
        </div>
        <!-- Video Slide 8 -->
        <div class="swiper-slide video-packages-slide">
          <div class="video-packages-slide-container">
            <video src="https://todossomosamigos.s3.us-east-1.amazonaws.com/Videos/sillones.mp4" muted loop></video>
          </div>
          <div class="video-packages-slide-content">
            <h1 class="package-price">$199.99</h1>
            <div class="video-packages-slide-content-bottom">
              <h2 class="package-name">Paquete Gastronómico</h2>
              <h3 class="package-description">Explora los mejores sabores de la ciudad</h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Controless -->
      <div class="video-packages-slider-control">
        <div class="swiper-button-prev video-packages-slider-arrow">
          <ion-icon name="arrow-back-outline"></ion-icon>
        </div>
        <div class="swiper-button-next video-packages-slider-arrow">
          <ion-icon name="arrow-forward-outline"></ion-icon>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var videoPackagesSlider = new Swiper('.video-packages-slider', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      loop: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 100,
        modifier: 2.5,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.video-packages-slider-control .swiper-button-next',
        prevEl: '.video-packages-slider-control .swiper-button-prev',
      },
      on: {
        init: function () {
          handleLazyLoadingAndPlayback(this);
        },
        slideChange: function () {
          handleLazyLoadingAndPlayback(this);
        },
      },
    });
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        const video = entry.target;

        if (entry.isIntersecting) {
          const dataSrc = video.getAttribute('data-src');
          if (dataSrc && !video.src) {
            video.setAttribute('src', dataSrc);
            video.load();
          }

          const swiperSlide = video.closest('.swiper-slide');
          if (swiperSlide && swiperSlide.classList.contains('swiper-slide-active')) {
            video.play().catch(e => console.log('Error de reproducción:', e));
          }
        } else {
          video.pause();
        }
      });
    });

    const videos = document.querySelectorAll('.custom-video-carousel__video');
    videos.forEach(video => {
      observer.observe(video);
    });

    function handleLazyLoadingAndPlayback(swiper) {
      const activeSlide = swiper.slides[swiper.activeIndex];
      const currentVideo = activeSlide.querySelector('video');

      if (currentVideo) {
        if (currentVideo.src) {
          currentVideo.play().catch(e => console.log('Error al reproducir video:', e));
        } else {
          const dataSrc = currentVideo.getAttribute('data-src');
          if (dataSrc) {
            currentVideo.setAttribute('src', dataSrc);
            currentVideo.load();
            currentVideo.play().catch(e => console.log('Error al reproducir video:', e));
          }
        }
      }

      swiper.el.querySelectorAll('video').forEach(video => {
        if (video !== currentVideo) video.pause();
      });
    }
  });
</script>
