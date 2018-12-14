<template>
    <body>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleControls" data-slide-to="1"></li>
                <li data-target="#carouselExampleControls" data-slide-to="2"></li>
            </ol>
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="images/slider1.jpg" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5> DAD Restaurant </h5>
                            <p> We cook here </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="images/slider2.jpg" alt="Second slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5> Our food </h5>
                            <p> We only serve freshly gathered ingredients </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="images/slider3.jpg" alt="Third slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5> You </h5>
                            <p> Our clients are our top priority </p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <section id="tools">
            <div class="container built-with d-flex justify-content-center">
                <div class="card-deck">
                    <div class="card">
                        <img class="card-img-top" src="/images/vue-logo.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Vue</h5>
                            <p class="card-text">Vue.js is an open-source JavaScript framework for building user interfaces and single-page applications.</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="/images/laravel-logo.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Laravel</h5>
                            <p class="card-text">Laravel is a free, open-source[3] PHP web framework, created by Taylor Otwell and intended for the development of web applications following the model–view–controller (MVC) architectural pattern and based on Symfony</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="/images/bootstrap-logo.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Bootstrap</h5>
                            <p class="card-text">Bootstrap is a free and open-source front-end framework for designing websites and web applications.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <div class="parallax"></div>
        <section id="about-us">
            <div class="container built-with d-flex justify-content-center">
                <div class="card-deck">
                    <div class="card">
                        <img class="card-img-top" src="/images/person-icon.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Rúben Lopes</h5>
                            <p class="card-text">IPL - ESTG, Sistemas de Informação. 2019</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="/images/person-icon.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Tiago Batista</h5>
                            <p class="card-text">IPL - ESTG, Sistemas de Informação. 2019</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="/images/person-icon.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Tiago Afonso</h5>
                            <p class="card-text">IPL - ESTG, Tecnologias de Informação. 2019</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <section id="ipl">
            <div class="container">
                <div class="card">
                    <div class="row no-gutters">
                        <div class="col-auto">
                            <img src="/images/pdad.png" class="img-fluid" alt="">
                        </div>
                        <div class="col">
                            <div class="card-block px-2">
                                <h4 class="card-title">Projeto de Desenvolvimento de Aplicações Distribuidas</h4>
                                <p class="card-text">This project’s objective is to implement a Single Page Application (SPA) for the management of a restaurant’s order system, using Vue.js framework for the development of the web client.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer w-100 text-muted">
                        ESTG Leiria
                    </div>
                </div>
            </div>
        </section>
        <div class="container footer bg-light">
            <div class="col">
                <p class="text-center">All rights reserved ®</p>
            </div>
    
        </div>
    </body>
</template>

<script>
    
</script>

<style scoped>
    #ipl .card {
        margin-top: 50px;
        margin-bottom: 50px;
    }
    
    #about-us img {
        width: 100%;
        padding: 15px;
    }
    
    .parallax {
        /* The image used */
        background-image: url("/images/slider3.jpg");
        /* Set a specific height */
        height: 500px;
        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-top: 50px;
        margin-bottom: 50px;
    }
    
    #tools img {
        width: 100%;
        padding: 15px;
    }
    
    #carouselExampleControls {
        margin-top: 56px;
        margin-bottom: 50px;
    }
</style>

