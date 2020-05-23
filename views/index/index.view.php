<?php

use App\Models\Templates;

$TEMPLATE = new Templates();


$TEMPLATE->owlCarousel = true;
$TEMPLATE->header();
?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->navBar(); ?>

        <div class="slider__container slider--one bg__cat--3">
            <div class="slide__container slider__activation__wrap owl-carousel">
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>Coleccion 2020</h2>
                                        <h1>Mujer</h1>
                                        <div class="cr__btn">
                                            <a href="<?php echo $RUTA; ?>productos?sexo=woman">Comprar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="<?php echo $RUTA; ?>galeria/img/woman.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide -->
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>Colección 2020</h2>
                                        <h1>Hombre</h1>
                                        <div class="cr__btn">
                                            <a href="<?php echo $RUTA; ?>productos?sexo=man">Comprar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="<?php echo $RUTA; ?>galeria/img/man.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide -->
            </div>
        </div>

        <section class="htc__category__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Nuevos productos</h2>
                            <p>Estamos preparados para acompañarte en tu compra</p>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30" id="container_productos">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Category Area -->
        <!-- Start Prize Good Area -->
        <section class="htc__good__sale bg__cat--3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <div class="fr__prize__inner">
                            <h2>Completa tu carrito y realiza tu pedido.</h2>
                            <h3>Profecionales estamos listos para atenderte.</h3>
                            <a class="fr__btn" href="<?php echo $RUTA; ?>carrito">Carrito</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <div class="prize__inner">
                            <div class="prize__thumb">
                                <img src="<?php echo $RUTA; ?>galeria/img/index_slide.jpg" alt="banner images">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Prize Good Area -->
        <!-- Start Product Area -->
        <section class="ftr__product__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Más vendidos</h2>
                            <p> Viste a la moda</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix" id="container_mas_vendidos">
                    </div>
                </div>
            </div>
        </section>
        <?php $TEMPLATE->footer(); ?>
        <!-- End Footer Style -->
    </div>
    <!-- Body main wrapper end -->

    <!-- Placed js at the end of the document so the pages load faster -->

    <?php $TEMPLATE->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/productos.js"></script>
    <script src="<?php echo $RUTA; ?>js/index/productos.js"></script>
</body>