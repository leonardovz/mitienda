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
    <div class="container container_principal">
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
                    <div class="row justify-content-center">

                        <!-- Grid column -->
                        <div class="col-md-3 pb-2"></div>
                        <div class="col-md-7">
                            <form id="formSendVerificar" class="text-center" style="color: #757575;" action="#!">

                                <!-- Email -->
                                <div class="md-form">
                                    <input type="email" id="email" class="form-control" placeholder="Tu correo">
                                    <label for="email">Ingresa tu correo</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="codeVerify" class="form-control" placeholder="Tu código">
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
    <?php
    $TEMPLATES->footer();
    $TEMPLATES->scripts();
    ?>

    <script>
        $(document).ready(function() {
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
                            url: RUTA + 'back/verificacion/',
                            data: 'opcion=verificacion&correo=' + correo + '&codigo=' + codVerificacion + '&' + formulario,
                            dataType: 'json',
                            error: function(xhr, status) {
                                console.log(JSON.stringify(xhr));
                            },
                            success: function(data) {
                                console.log(data);
                                if (data.respuesta == 'exito') {
                                    Swal.fire('¡Listo!', data.Texto, 'success');
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
        });
    </script>
</body>

</html>