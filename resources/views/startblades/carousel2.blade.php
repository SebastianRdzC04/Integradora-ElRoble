@php
    // Estas es la consulta para obtener las imagenes del carrusel cuando se suban al S3 De amazon
    use App\Models\Service;
    use Illuminate\Support\Facades\DB;

    $serviciosMasCotizados = DB::table('quotes_services')->select('service_id', DB::raw('COUNT(*) as total_cotizaciones'))->groupBy('service_id')->orderByDesc('total_cotizaciones')->limit(7)->get();

    $idsServicios = $serviciosMasCotizados->pluck('service_id');

    $packages = Service::whereIn('id', $idsServicios)->get();
    
@endphp

<style>
  /* Estilos específicos para Packages */
#packages-carousel {
  padding: 4rem 0;
}

.packages-slider {
  height: 52rem;
  padding: 2rem 0;
}

.packages-slide {
  width: 37rem;
  height: 42rem;
  position: relative;
}

.packages-slide-img img {
  width: 100%;
  height: 100%;
  height: 410px;
  border-radius: 2rem;
  object-fit: cover;
}

.packages-slide-content {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.packages-slide-content .package-price {
  position: absolute;
  top: 2rem;
  right: 2rem;
  color: white;
}

.packages-slide-content-bottom {
  position: absolute;
  bottom: 2rem;
  left: 2rem;
  color: white;
}

.packages-slider-control {
  display: flex;
  justify-content: center;
  position: relative;
  bottom: 2rem;
}

.packages-slider-arrow {
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

.packages-slider-arrow ion-icon {
  font-size: 2rem;
  color: #222224;
}

.packages-slider .swiper-pagination-bullet {
  background: #ccc;
}

.packages-slider .swiper-pagination-bullet-active {
  background: #ec994b;
}

</style>
<section id="packages-carousel" style="mask-image: linear-gradient(to top, #000000 91%, #91ef0400); background-color: antiquewhite;">
  <div class="container">
    <h3 class="text-center section-subheading">- Paquetes más cotizados -</h3>
    <h1 class="text-center section-heading">Packages</h1>
  </div>
  <div class="container">
    <div class="swiper packages-slider">
      <div class="swiper-wrapper">
        <!-- Slide-start -->
        <div class="swiper-slide packages-slide">
          <div class="packages-slide-img">
            <img src="{{ $packages->get(0)->image_path }}" alt="{{ $packages->get(0)->name }}">
          </div>
          <div class="packages-slide-content">
            <h1 class="package-price">${{ $packages->get(0)->price }}</h1>
            <div class="packages-slide-content-bottom">
              <h2 class="package-name">{{ $packages->get(0)->name }}</h2>
              <h3 class="package-description">{{ $packages->get(0)->description }}</h3>
            </div>
          </div>
        </div>
        <!-- Slide-end -->
        <!-- Repite más slides como el anterior -->
      </div>

      <!-- Controls -->
      <div class="packages-slider-control">
        <div class="swiper-button-prev packages-slider-arrow">
          <ion-icon name="arrow-back-outline"></ion-icon>
        </div>
        <div class="swiper-button-next packages-slider-arrow">
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
  var packagesSlider = new Swiper('.packages-slider', {
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
      nextEl: '.packages-slider-control .swiper-button-next',
      prevEl: '.packages-slider-control .swiper-button-prev',
    }
  });
</script>
