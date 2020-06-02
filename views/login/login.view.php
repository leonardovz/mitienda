<?php

use App\Models\Templates;

$TEMPLATES = new Templates();
// $TEMPLATES->recaptcha = true;
$TEMPLATES->header();
?>


<body>
    <!-- Main navigation -->
    <header>
        <!--Navbar-->
        <?php $TEMPLATES->navBar('', $USERSYSTEM); ?>
    </header>
    <div class="container-fluid container_principal"><br>
        <div class="row py-0">
            <div class="col-md-12 bg-dark text-white py-5 text-md-right ">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6 text-center">
                        <h3 class="h1 font-weight-lighter text-white my-md-5 my-2 ">Inicio de sesión</h3>
                        <div class="card">
                            <div class="card-body px-lg-5 pt-5">
                                <form id="formLogin" class="text-center " style="color: #757575;" action="<?php echo $RUTA; ?>perfil">

                                    <!-- Email -->
                                    <div class="md-form">
                                        <input type="email" id="correo" name="correo" class="form-control">
                                        <label for="correo">Correo</label>
                                    </div>
                                    <!-- Password -->
                                    <div class="md-form">
                                        <input type="password" id="password" name="password" class="form-control">
                                        <label for="password">Contraseña</label>
                                    </div>
                                    <div class="col-md-12 p-0 mb-5">
                                        <div class="g-recaptcha" data-sitekey="<?php echo $TEMPLATES->keyCaptcha_public; ?>"></div>
                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div>
                                            <a href="<?php echo $RUTA ?>recuperarCuenta">¿Olvidaste tu contraseña?</a>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-info btn-rounded btn-block my-4" id="send_form" type="submit">Ingresar</button>
                                    <p>¿No eres miembro?
                                        <a href="<?php echo $RUTA; ?>registro">Regístrate</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Footer -->
    <?php $TEMPLATES->footer(); ?>
    <?php $TEMPLATES->scripts(); ?>
    <script>
        <?php echo "var login  = " . ($_log_admin ? '"administrador"' : '""') . ";"; ?>
    </script>
    <script src="<?php echo $RUTA; ?>js/login/login.js"></script>
</body>

</html>