<?php

use App\Models\Templates;

$TEMPLATE = new Templates();
$TEMPLATE->USERSYSTEM = $USERSYSTEM;


$TEMPLATE->owlCarousel = true;
$TEMPLATE->header();
?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->navBar(); ?>
    </div>
    <section class="htc__contact__area ptb--100 bg__white container_principal">
        <div class="container ">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="title__line--6">CONTACT US</h2>
                    <div class="address">
                        <div class="address__icon">
                            <i class="icon-location-pin icons"></i>
                        </div>
                        <div class="address__details">
                            <h2 class="ct__title">our address</h2>
                            <p>666 5th Ave New York, NY, United </p>
                        </div>
                    </div>
                    <div class="address">
                        <div class="address__icon">
                            <i class="icon-envelope icons"></i>
                        </div>
                        <div class="address__details">
                            <h2 class="ct__title">openning hour</h2>
                            <p>666 5th Ave New York, NY, United </p>
                        </div>
                    </div>

                    <div class="address">
                        <div class="address__icon">
                            <i class="icon-phone icons"></i>
                        </div>
                        <div class="address__details">
                            <h2 class="ct__title">Phone Number</h2>
                            <p>123-6586-587456</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php $TEMPLATE->footer(); ?>
    <?php $TEMPLATE->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/productos.js"></script>
    <script src="<?php echo $RUTA; ?>js/index/productos.js"></script>
</body>