<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <title>El Roble</title>
    <!--el app esta en el blade del navbar para optimizar espacio hay esta el script del navbar-->
</head>
<body>
<!--importando el blade del navbar-->
    @include('layouts.navbar')

    <main style="min-height: 200vh;">
    <div class="custom-bg custom-back-image align-content-center" style="background-image: url('{{ asset('js/images/El Roble principal image.jpg') }}');">
        
        <div class="d-flex justify-content-center text-bg-info">
            <div>
                <p class="text-image-front p-3">Este es el texto de muestra</p>
            </div>
        </div>
    </div>
    <!--dentro de aqui debe de ir todo el contenido de la pagina-->

<!--importando el blade del carousel-->
    @include('layouts.carousel.carousel')

    <section id="paquetes">
    <div class="slider">
            <div class="item">
                <h1>Slide 1</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <div class="item">
                <h1>Slide 2</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <div class="item">
                <h1>Slide 3</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <div class="item">
                <h1>Slide 4</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <div class="item">
                <h1>Slide 5</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <div class="item">
                <h1>Slide 6</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <div class="item">
                <h1>Slide 7</h1>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere magni magnam unde ipsam repudiandae explicabo expedita labore, sequi minus neque beatae voluptatum, quasi accusamus quia quis voluptas laborum ad! Ab totam doloribus, excepturi possimus rem vel quia fugit molestiae officiis!
            </div>
            <button id="next">></button>
            <button id="prev"><</button>
        </div>
    </section>
    @include('layouts.carousel.carousel')

    <section id="form">

    </section>

    <section id="googlemaps">

    </section>

    <section id="images">

    </section>
    
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <Script>
    let items = document.querySelectorAll('.slider .item');
    let next = document.getElementById('next');
    let prev = document.getElementById('prev');
    
    let active = 3;
    function loadShow(){
        let stt = 0;
        items[active].style.transform = `none`;
        items[active].style.zIndex = 1;
        items[active].style.filter = 'none';
        items[active].style.opacity = 1;
        for(var i = active + 1; i < items.length; i++){
            stt++;
            items[i].style.transform = `translateX(${120*stt}px) scale(${1 - 0.2*stt}) perspective(16px) rotateY(-1deg)`;
            items[i].style.zIndex = -stt;
            items[i].style.filter = 'blur(5px)';
            items[i].style.opacity = stt > 2 ? 0 : 0.6;
        }
        stt = 0;
        for(var i = active - 1; i >= 0; i--){
            stt++;
            items[i].style.transform = `translateX(${-120*stt}px) scale(${1 - 0.2*stt}) perspective(16px) rotateY(1deg)`;
            items[i].style.zIndex = -stt;
            items[i].style.filter = 'blur(5px)';
            items[i].style.opacity = stt > 2 ? 0 : 0.6;
        }
    }
    loadShow();
    next.onclick = function(){
        active = active + 1 < items.length ? active + 1 : active;
        loadShow();
    }
    prev.onclick = function(){
        active = active - 1 >= 0 ? active - 1 : active;
        loadShow();
    }
  </Script>
  
</body>
</html>
i