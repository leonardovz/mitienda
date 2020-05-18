<?php

use App\Models\Templates;

$TEMPLATES = new Templates();

$TEMPLATES->owlCarousel = true;
$TEMPLATES->recaptcha = true;
$TEMPLATES->header();
?>


<body>
    <!-- Main navigation -->
    <header>
        <!--Navbar-->
        <?php $TEMPLATES->navBar('', $USERSYSTEM); ?>
    </header>
    <div class="container-fluid "><br>
        <div class="row py-0">
            <div class="col-md-4 bg-dark text-white py-5 text-md-right ">
                <div class="row">
                    <div class="col pr-md-5 pr-2">
                        <h3 class="h1 font-weight-lighter text-white my-md-5 my-2 ">Registro</h3>
                    </div>
                    <div class="col-md-12 col-4">
                        <img src="<?php echo $RUTA; ?>galeria/sistema/logo/logo_v3_white" class="w-50 rounded-circle" alt="">
                    </div>

                </div>
            </div>
            <div class="col-md-8 bg-white py-md-5 py-2">
                <div class="card">
                    <div class="card-body">
                        <form id="formRegistro" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="nombre" name="nombre" class="form-control">
                                        <label for="nombre" class="font-weight-light">Nombre</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="apellido" name="apellido" class="form-control">
                                        <label for="apellido" class="font-weight-light">Apellidos</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="md-form">
                                        <input type="email" id="email" name="email" class="form-control">
                                        <label for="email" class="font-weight-light">Email</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="md-form">
                                        <input type="email" id="emailR" name="emailR" class="form-control">
                                        <label for="emailR" class="font-weight-light">Confirmación de email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="md-form">
                                        <input type="password" id="password" name="password" class="form-control">
                                        <label for="password" class="font-weight-light">Contraseña</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="md-form">
                                        <input type="password" name="passwordR" id="passwordR" class="form-control">
                                        <label for="passwordR" class="font-weight-light">Repite la contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mb-5 text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terminos-condiciones" name="terminos-condiciones">
                                    <label class="custom-control-label" for="terminos-condiciones">Acepto los <a target="_blank" href="<?php echo $RUTA; ?>galeria/documentos/terminos_y_condiciones.pdf">Términos y Condiciones</a></label>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mb-2">
                                <div class="g-recaptcha" data-sitekey="<?php echo $TEMPLATES->keyCaptcha_public; ?>"></div>
                            </div>

                            <div class="text-center py-md-4 py-2 mt-3">
                                <button class="btn btn-cyan" type="submit">Registrarme</button>
                            </div>
                            <div class="text-center py-md-4 py-2 mt-0">
                                <p>¿Ya eres miembro?
                                    <a href="<?php echo $RUTA; ?>login">Ingresa</a>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="card-body" id="errores">

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php $TEMPLATES->footer(); ?>
    <?php $TEMPLATES->scripts(); ?>
    <script src="<?php echo $RUTA; ?>views/login/script/registro.js"></script>
</body>

</html>