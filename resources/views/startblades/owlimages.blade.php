
<div class="carousel slide" 
id="carouselDemo"
data-bs-wrap="true" 
data-bs-ride="carousel">

    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="{{asset('images/imagen1.jpg')}}" class="w-100">
            <div class="carousel-caption">
                <h5>Title Slide 0</h5>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi, nemo?
                </p>
            </div>
        </div>

        <div class="carousel-item " 
        data-bs-interval="2000">
            <img src="{{asset('images/imagen2.jpg')}}" class="w-100">
            <div class="carousel-caption">
                <h5>Title Slide 1</h5>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi, nemo?
                </p>
            </div>
        </div>

        <div class="carousel-item ">
            <img src="{{asset('images/imagen3.jpg')}}" class="w-100">
            <div class="carousel-caption">
                <h5>Title Slide 2</h5>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi, nemo?
                </p>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" 
    type="button"
    data-bs-target="#carouselDemo" 
    data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next"
    type="button"
    data-bs-target="#carouselDemo"
    data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
</button>

    <div class="carousel-indicators">
        <button type="button" class="active"
            data-bs-target="#carouselDemo"
            data-bs-slide-to="0">
            <img src="{{asset('images/imagen1.jpg')}}" />
        </button>

        <button type="button" 
        data-bs-target="#carouselDemo"
        data-bs-slide-to="1">
            <img src="{{asset('images/imagen2.jpg')}}" />
        </button>

        <button type="button"
        data-bs-target="#carouselDemo"
        data-bs-slide-to="2">
            <img src="{{asset('images/imagen3.jpg')}}" />
        </button>
    </div>

</div>