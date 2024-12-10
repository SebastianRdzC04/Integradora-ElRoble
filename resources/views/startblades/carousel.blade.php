@php
    // Estas es la consulta para obtener las imagenes del carrusel cuando se suban al S3 De amazon
    use App\Models\Service;
    use Illuminate\Support\Facades\DB;

    $serviciosMasCotizados = DB::table('quotes_services')->select('service_id', DB::raw('COUNT(*) as total_cotizaciones'))->groupBy('service_id')->orderByDesc('total_cotizaciones')->limit(7)->get();

    $idsServicios = $serviciosMasCotizados->pluck('service_id');

    $servicios = Service::whereIn('id', $idsServicios)->get();
    
@endphp

<section id="tranding" style="mask-image: linear-gradient(to top, #000000 91%, #91ef0400); background-color: antiquewhite;">
      <div class="container">
        <h3 class="text-center section-subheading">- Servicios mas cotizados -</h3>
        <h1 class="text-center section-heading">Servicios</h1>
      </div>
      <div class="container">
        <div class="swiper tranding-slider">
          <div class="swiper-wrapper">
            <!-- Slide-start -->
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(0)->image_path }}" alt="{{ $servicios->get(0)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">${{ $servicios->get(0)->price }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(0)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(0)->decription }}</span>
                  </h3>
                </div>
              </div>
            </div>
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(1)->image_path }}" alt="{{ $servicios->get(1)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">${{ $servicios->get(1)->price }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(1)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(1)->description }}</span>
                  </h3>
                </div>
              </div>
            </div>
            <!-- Slide-end -->
            <!-- Slide-start -->
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(2)->image_path }}" alt="{{ $servicios->get(2)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">{{ $servicios->get(2)->price }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(2)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(2)->description }}</span>
                    
                  </h3>
                </div>
              </div>
            </div>
            <!-- Slide-end -->
            <!-- Slide-start -->
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(3)->image_path }}" alt="{{ $servicios->get(3)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">${{ $servicios->get(3)->price }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(3)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(3)->description }}</span>
                    
                  </h3>
                </div>
              </div>
            </div>
            <!-- Slide-end -->
            <!-- Slide-start -->
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(4)->image_path }}" alt="{{ $servicios->get(4)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">${{ $servicios->get(4)->price }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(4)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(4)->description }}</span>
                    
                  </h3>
                </div>
              </div>
            </div>
            <!-- Slide-end -->
            <!-- Slide-start -->
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(5)->image_path }}" alt="{{ $servicios->get(5)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">${{ $servicios->get(5)->coast }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(5)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(5)->description }}</span>
                    
                  </h3>
                </div>
              </div>
            </div>
            <!-- Slide-end -->
            <!-- Slide-start -->
            <div class="swiper-slide tranding-slide">
              <div class="tranding-slide-img">
                <img src="{{ $servicios->get(6)->image_path }}" alt="{{ $servicios->get(6)->name }}">
              </div>
              <div class="tranding-slide-content">
                <h1 class="food-price">${{ $servicios->get(6)->price }}</h1>
                <div class="tranding-slide-content-bottom">
                  <h2 class="food-name">
                  {{ $servicios->get(6)->name }}
                  </h2>
                  <h3 class="food-rating">
                    <span>{{ $servicios->get(6)->description }}</span>
                    
                  </h3>
                </div>
              </div>
            </div>
            <!-- Slide-end -->
          </div>

          <div class="tranding-slider-control">
            <div class="swiper-button-prev slider-arrow">
              <ion-icon name="arrow-back-outline"></ion-icon>
            </div>
            <div class="swiper-button-next slider-arrow">
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
  var TrandingSlider = new Swiper('.tranding-slider', {
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
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
                }
              });
</script>