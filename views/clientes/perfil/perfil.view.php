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
    <section class="htc__contact__area ptb--100 bg__white">
        <div class="container container_principal">
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-default" href="<?php echo $RUTA; ?>sistema/mispedidos"> Revisar mis pedidos</a>
                </div>

                <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="title__line--6">Tus direcciones</h2>
                    <div class="address">
                        <div class="address__icon">
                            <i class="icon-location-pin icons"></i>
                        </div>
                        <div class="address__details">
                            <h2 class="ct__title">Dirección</h2>
                            <p>666 5th Ave New York, NY, United </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="contact-form-wrap mt--60">
                    <div class="col-xs-12">
                        <div class="contact-title">
                            <h2 class="title__line--6">Datos de la cuenta</h2>
                            <a href="" type="submit" class="fv-btn">Modificar</a>
                            <br><br>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <form id="contact-form" action="#" method="post">
                            <div class="single-contact-form">
                                <div class="contact-box name">
                                    <input type="text" name="name" placeholder="Nombre*" disabled value="<?php echo $USERSYSTEM['nombre']; ?>">
                                    <input type="text" name="email" placeholder="Apellidos*" disabled value="<?php echo $USERSYSTEM['apellidos']; ?>">
                                </div>
                            </div>
                            <div class="single-contact-form">
                                <div class="contact-box subject">
                                    <input type="email" name="subject" placeholder="Correo*" disabled value="<?php echo $USERSYSTEM['correo']; ?>">
                                </div>
                            </div>
                            <div class="single-contact-form">
                                <div class="address">
                                    <div class="address__icon">
                                        <i class="icon-location-pin icons"></i>
                                    </div>
                                    <div class="address__details">
                                        <h2 class="ct__title">Dirección principal</h2>
                                        <p>666 5th Ave New York, NY, United </p>
                                    </div>
                                </div>
                                <a href="" type="submit" class="fv-btn">Configurar dirección principal</a>
                                <a href="" type="submit" class="fv-btn">Agregar dirección</a>

                            </div>
                            <div class="contact-btn">
                                <button type="submit" class="fv-btn disabled" disabled="disabled">Guardar configuracion</button>
                            </div>
                        </form>
                        <br>
                        <hr>
                        <button type="submit" class="fv-btn disabled" disabled="disabled">Cambiar Contraseña</button>
                        <div class="form-output">
                        </div>
                        <div class="form-output">
                            <p class="form-messege"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php $TEMPLATE->footer(); ?>
    <?php $TEMPLATE->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/models/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/index/productos.js"></script>
</body>