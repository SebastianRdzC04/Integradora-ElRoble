<style>
    .custom-carousel {
        width: 100%;
        max-width: 1300px;
        height: 700px;
        margin: auto;
        position: relative;
        overflow: hidden;
    }
    .custom-carousel__container {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        display: flex;
        transition: transform 1s ease;
    }
    .custom-carousel__item {
        flex: 0 0 100%;
        width: 100%;
        height: 100%;
        position: relative;
    }
    .custom-carousel__image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .custom-carousel__text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-align: center;
        font-size: 24px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        width: 80%;
    }
    .custom-carousel__indicators {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
    }
    .custom-carousel__indicator {
        list-style: none;
        width: 10px;
        height: 10px;
        background-color: rgba(255,255,255,0.5);
        margin: 0 5px;
        border-radius: 50%;
        cursor: pointer;
        transition: 0.3s;
    }
    .custom-carousel__indicator--active {
        background-color: white;
        transform: scale(1.2);
    }
    @media screen and (max-width: 768px) {
        .custom-carousel {
            height: 400px;
        }
        .custom-carousel__text {
            font-size: 18px;
        }
    }
</style>

<div class="custom-carousel" style="mask-image: linear-gradient(to bottom, #000000 91%, #91ef0400);">
    <div class="custom-carousel__container">
        <div class="custom-carousel__item">
            <img class="custom-carousel__image" src="{{asset('images/imagen1.jpg')}}" alt="Imagen 1">
            <div class="custom-carousel__text">Texto para la imagen 1</div>
        </div>
        <div class="custom-carousel__item">
            <img class="custom-carousel__image" src="{{asset('images/imagen2.jpg')}}" alt="Imagen 2">
            <div class="custom-carousel__text">Texto para la imagen 2</div>
        </div>
        <div class="custom-carousel__item">
            <img class="custom-carousel__image" src="{{asset('images/imagen3.jpg')}}" alt="Imagen 3">
            <div class="custom-carousel__text">Texto para la imagen 3</div>
        </div>
        <div class="custom-carousel__item">
            <img class="custom-carousel__image" src="{{asset('images/imagen4.jpg')}}" alt="Imagen 4">
            <div class="custom-carousel__text">Texto para la imagen 4</div>
        </div>
        <div class="custom-carousel__item">
            <img class="custom-carousel__image" src="{{asset('images/imagen5.jpg')}}" alt="Imagen 5">
            <div class="custom-carousel__text">Texto para la imagen 5</div>
        </div>
    </div>
    <ul class="custom-carousel__indicators">
        <li class="custom-carousel__indicator custom-carousel__indicator--active"></li>
        <li class="custom-carousel__indicator"></li>
        <li class="custom-carousel__indicator"></li>
        <li class="custom-carousel__indicator"></li>
        <li class="custom-carousel__indicator"></li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.custom-carousel__container');
        const items = document.querySelectorAll('.custom-carousel__item');
        const indicators = document.querySelectorAll('.custom-carousel__indicator');
        
        let currentIndex = 0;
        const totalItems = items.length;

        function moveToIndex(index) {
            if (index < 0) {
                index = totalItems - 1;
            } else if (index >= totalItems) {
                index = 0;
            }
            carousel.style.transform = `translateX(-${index * 100}%)`;
            currentIndex = index;
            updateIndicators();
        }

        function updateIndicators() {
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('custom-carousel__indicator--active');
                } else {
                    indicator.classList.remove('custom-carousel__indicator--active');
                }
            });
        }

        function autoAdvance() {
            moveToIndex(currentIndex + 1);
        }

        let intervalId = setInterval(autoAdvance, 7000);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                clearInterval(intervalId);
                moveToIndex(index);
                intervalId = setInterval(autoAdvance, 7000);
            });
        });

        const carouselElement = document.querySelector('.custom-carousel');
        carouselElement.addEventListener('mouseenter', () => clearInterval(intervalId));
        carouselElement.addEventListener('mouseleave', () => {
            clearInterval(intervalId);
            intervalId = setInterval(autoAdvance, 7000);
        });
    });
</script>