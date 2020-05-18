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
        <?php $TEMPLATES->navBar('', $USERSYSTEM); ?>
        <br><br>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Jumbotron -->
                <div class="jumbotron text-center my-5">

                    <!-- Title -->
                    <h2 class="card-title h2"><?php echo $TEMPLATES->SISTEMNAME; ?> </h2>
                    <!-- Subtitle -->
                    <p class="blue-text my-4 font-weight-bold">Para continuar con la recuperación es necesario que ingreses tu correo electrónico</p>

                    <!-- Grid row -->
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-7">
                            <form id="verificarpOne" class="text-center" style="color: #757575;" action="#!">
                                <div class="md-form">
                                    <input type="email" id="correoNew" class="form-control">
                                    <label for="correoNew">Ingresa tu correo</label>
                                </div>
                                <div class="col-md-12 p-0 mb-5">
                                    <div class="g-recaptcha" data-sitekey="<?php echo $TEMPLATES->keyCaptcha_public; ?>"></div>
                                </div>
                                <button class="btn btn-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Enviar código de recuperación</button>
                                <p><a id="codigoya" class="text-primary">- YA TENGO UN CÓDIGO -</a></p>
                            </form>
                            <form id="verificarTwo" class="text-center" style="color: #757575; display: none;">
                                <div class="md-form">
                                    <input type="text" id="codigoNew" class="form-control">
                                    <label for="codigoNew">Ingresa tu código</label>
                                </div>
                                <div class="md-form" style="display: none;">
                                    <input type="password" id="passNew" class="form-control">
                                    <label for="passNew">Nueva contraseña</label>
                                </div>
                                <div class="md-form" style="display: none;">
                                    <input type="password" id="passNewR" class="form-control">
                                    <label for="passNewR">Repite tu nueva contraseña</label>
                                </div>

                                <button class="btn btn-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" id="nextFile">Siguiente</button>
                                <a id="volverMail" class=" waves-effect text-primary"><i class="fas fa-backward mr-1"></i> Regresar </a>

                            </form>
                        </div>
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
    <?php $TEMPLATES->footer(); ?>
    <?php $TEMPLATES->scripts(); ?>
    <script>
        $(document).ready(function() {
            var pasos = 1;
            $("#verificarpOne").on('submit', function(e) {
                e.preventDefault();
                let correo = $("#correoNew").val();
                if (correo != "") {
                    var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                    if (expresion.test(correo)) {
                        cambiarPassword(correo);
                    } else {
                        Swal.fire(
                            'ERROR',
                            'El correo electrónico que has ingresado no esta escrito de forma correcta',
                            'error'
                        );
                    }
                } else {
                    Swal.fire(
                        'ERROR',
                        'Es necesario que introduzcas tu correo electrónico',
                        'error'
                    );
                }
            });

            $("#volverMail").on('click', function() {
                $("#verificarpOne").show();
                $("#verificarTwo").hide();
            });
            $("#codigoya").on('click', function() {
                let correo = $("#correoNew").val();
                if (correo != "") {
                    var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                    if (expresion.test(correo)) {
                        $("#verificarpOne").hide();
                        $("#verificarTwo").show();
                    } else {
                        Swal.fire('ERROR', 'El correo electrónico que has ingresado no esta escrito de forma correcta', 'error');
                    }
                } else {
                    Swal.fire('ERROR', 'Es necesario que introduzcas tu correo electrónico', 'error');
                }
            });
            $("#verificarTwo").on('submit', function(e) {
                e.preventDefault();
                let errores = 0;
                let correo = $("#correoNew").val();
                let codigo = $("#codigoNew").val();
                let passNew = $("#passNew").val();
                let passNewR = $("#passNewR").val();
                if (correo != "") {
                    var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                    if (!expresion.test(correo)) {
                        errores++;
                    }
                }
                if (codigo == "" || codigo.length < 15) {
                    errores++
                }
                if (errores == 0) {
                    if (pasos == 1) {
                        cambiarPassword(correo, codigo);
                    } else if (pasos == 2) {
                        cambiarPassword(correo, codigo, passNew, passNewR);
                    }
                }
            });

            function cambiarPassword(correo, codigo = false, pass = false, passR = false) {
                var codigo = (codigo) ? '&codigo=' + codigo : "";
                var pass = (pass) ? '&pass=' + pass : "";
                var passR = (passR) ? '&passR=' + passR : "";
                var correo = (correo) ? '&correo=' + correo : "";
                var paso = (pasos > 1) ? '&paso=' + pasos : "";
                var datosRec = correo + codigo + pass + passR + paso;
                $.ajax({
                    type: "POST",
                    url: RUTA + 'views/login/php/login.php',
                    dataType: "json",
                    data: 'opcion=recuperacion' + datosRec,
                    error: function(xhr, resp) {
                        console.log(xhr.responseText);
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.respuesta == 'exito') {
                            Swal.fire(
                                'EXITO',
                                data.Texto,
                                'success'
                            );
                            setTimeout(() => {
                                if (data.change == "si") location.replace(RUTA + 'login');
                            }, 1200);


                        } else if (data.respuesta == 'verificado') {
                            $("#codigoNew").parent().hide();
                            $("#passNew").parent().show();
                            $("#passNewR").parent().show();
                            pasos = 2;
                        } else {
                            Swal.fire(
                                'ERROR',
                                data.Texto,
                                'error'
                            );
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>