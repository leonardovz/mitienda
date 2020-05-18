<?php

use App\Models\Templates;

$TEMPLATES = new Templates();

$TEMPLATES->recaptcha = true;
$TEMPLATES->header();
?>


<body>
    <!-- Main navigation -->
    <header>
        <!--Navbar-->
        <?php $TEMPLATES->navBar('verificar', $USERSYSTEM); ?>
        <br><br>
    </header>
    <?php if ($idCodigo) { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Jumbotron -->
                    <div class="jumbotron text-center my-5">

                        <!-- Title -->
                        <h2 class="card-title h2"><?php echo $TEMPLATES->SISTEMNAME; ?> </h2>
                        <!-- Subtitle -->
                        <p class="blue-text my-4 font-weight-bold">Para iniciar sesión es necesario continuar con la validación </p>

                        <!-- Grid row -->
                        <div class="row d-flex justify-content-center">

                            <!-- Grid column -->
                            <div class="col-xl-7 pb-2">

                                <p class="card-text">Para asegurarnos de que seas tú, es necesario que ingreses nuevamente tu correo electrónico registrado</p>
                                <p><b>Tu código es: </b> <?php echo $idCodigo; ?></p>
                            </div>
                            <div class="col-md-7">
                                <form id="formVerificar" class="text-center" style="color: #757575;" action="#!">

                                    <!-- Email -->
                                    <div class="md-form">
                                        <input type="hidden" id="codVerificacion" value="<?php echo $idCodigo; ?>" style="display:none;">
                                        <input type="email" id="correoVerificar" class="form-control">
                                        <label for="correoVerificar">Ingresa tu correo</label>
                                    </div>
                                    <div class="col-md-12 p-0 mb-5">
                                        <div class="g-recaptcha" data-sitekey="<?php echo $TEMPLATES->keyCaptcha_public; ?>"></div>
                                    </div>
                                    <button class="btn btn-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" id=>Validar correo electrónico</button>
                                </form>
                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                        <hr class="my-4">

                        <div class="pt-2">
                            <a href="<?php echo $RUTA; ?>" type="button" class="btn btn-blue waves-effect">Volver <span class="fas fa-home ml-1"></span></a>
                            <!-- <a href="<?php echo $RUTA; ?>planes" type="button" class="btn btn-outline-primary waves-effect">Validar mi cuenta <i class="fas fa-download ml-1"></i></a> -->
                        </div>

                    </div>
                    <!-- Jumbotron -->
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Jumbotron -->
                    <div class="jumbotron text-center my-5">

                        <!-- Title -->
                        <h2 class="card-title h2"><?php echo $TEMPLATES->SISTEMNAME; ?> </h2>
                        <!-- Subtitle -->
                        <p class="blue-text mb-0 font-weight-bold">Para continuar con la validación es necesario contar con un código de verificación</p>
                        <p class="font-weight-lighter" style="font-size: 14px">El código de verificación ha sido enviado a tu bandeja de correo electrónico</p>

                        <!-- Grid row -->
                        <div class="row d-flex justify-content-center">

                            <!-- Grid column -->
                            <div class="col-xl-7 pb-2">
                                <!-- <p class="card-text">¿Aún no recibes tu código?</p> -->
                            </div>
                            <div class="col-md-7">
                                <form id="formSendVerificar" class="text-center" style="color: #757575;" action="#!">

                                    <!-- Email -->
                                    <div class="md-form">
                                        <input type="email" id="email" class="form-control">
                                        <label for="email">Ingresa tu correo</label>
                                    </div>
                                    <div class="md-form">
                                        <input type="text" id="codeVerify" class="form-control">
                                        <label for="codeVerify">Código</label>
                                    </div>
                                    <button class="btn btn-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Verificar</button>
                                </form>
                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                        <hr class="my-4">

                        <div class="pt-2">
                            <a href="<?php echo $RUTA; ?>" type="button" class="btn btn-outline-primary waves-effect">Volver <i class="fas fa-home ml-1"></i></a>
                            <!-- <a href="<?php echo $RUTA; ?>registro" type="button" class="btn btn-blue waves-effect">Registrarme <span class="far fa-gem ml-1"></span></a> -->
                        </div>

                    </div>
                    <!-- Jumbotron -->
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
    $TEMPLATES->footer();
    $TEMPLATES->scripts();
    ?>

    <script>
        $(document).ready(function() {
            <?php if ($idCodigo) { ?>
                $("#formVerificar").on('submit', function(e) {
                    e.preventDefault();
                    let correo = $("#correoVerificar").val();
                    let codVerificacion = $("#codVerificacion").val();
                    var formulario = $(this).serialize();
                    if (correo != "") {
                        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                        if (expresion.test(correo)) {
                            $.ajax({
                                type: 'POST',
                                url: RUTA + 'views/login/php/login.php',
                                data: 'opcion=verificacion&email=' + correo + '&codVerificacion=' + codVerificacion + '&' + formulario,
                                dataType: 'json',
                                error: function(xhr, status) {
                                    console.log(JSON.stringify(xhr));
                                },
                                success: function(data) {
                                    if (data.respuesta == 'exito') {
                                        Swal.fire('¡Listo!', data.Texto, 'success');
                                        setTimeout(() => {
                                            location.href = RUTA + 'login';
                                        }, 1500);
                                    } else {
                                        Swal.fire('Opss!', data.Texto, 'error');
                                    }
                                }
                            });
                        } else {
                            Swal.fire('Opss!', 'El correo electrónico que has ingresado no esta escrito de forma correcta', 'error');
                        }
                    } else {
                        Swal.fire('Opss!', 'Es necesario que introduzcas tu correo electrónico', 'error');
                    }
                    // alert("HOLA que hace");
                });
            <?php } else { ?>

                $("#formSendVerificar").on('submit', function(e) {
                    e.preventDefault();
                    let correo = $("#email").val();
                    let codVerificacion = $("#codeVerify").val();
                    var formulario = $(this).serialize();
                    if (correo != "") {
                        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                        if (expresion.test(correo)) {
                            $.ajax({
                                type: 'POST',
                                url: RUTA + 'views/login/php/login.php',
                                data: 'opcion=verificacion&email=' + correo + '&codVerificacion=' + codVerificacion + '&' + formulario,
                                dataType: 'json',
                                error: function(xhr, status) {
                                    console.log(JSON.stringify(xhr));
                                },
                                success: function(data) {
                                    if (data.respuesta == 'exito') {
                                        Swal.fire('¡Listo!', data.Texto, 'error');
                                        setTimeout(() => {
                                            location.href = RUTA + 'login';
                                        }, 2500);
                                    } else {
                                        Swal.fire('Opss!', data.Texto, 'error');
                                    }
                                }
                            });
                        } else {
                            Swal.fire('Opss!', 'El correo electrónico que has ingresado no esta escrito de forma correcta', 'error');
                        }
                    } else {
                        Swal.fire('Opss!', 'Es necesario que introduzcas tu correo electrónico', 'error');
                    }
                });
            <?php } ?>

        });
    </script>
</body>

</html>