<?php

use App\Models\Templates;

$TEMPLATES = new Templates();

$TEMPLATES->header();

?>

<body>
    <!-- Main navigation -->
    <header class="mb-5">
        <!--Navbar-->
        <?php $TEMPLATES->navBar('carrito'); ?>
        <br><br><br>
    </header>
    <div class="container">

        <!--Section: Main info-->
        <section class="mt-5 wow fadeIn">

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <img src="<?php echo $RUTA; ?>galeria/sistema/images/SnSanFranciscoCF.png" class="img-fluid z-depth-1-half" alt="">

                </div>
                <div class="col-md-6 mb-4 text-justify">

                    <!-- Main heading -->
                    <h3 class="h3 mb-3"><?php echo $TEMPLATES->SISTEMNAME; ?> </h3>
                    <p>Para continuar es necesario iniciar sesión y completar tu perfil
                        <strong><?php echo $TEMPLATES->SISTEMNAME; ?></strong> .</p>
                    <p>Permite a las personas que sepan quién les esta vendiendo o comprando.</p>
                    <!-- Main heading -->

                    <hr>

                    <p>
                        <strong>80%</strong> de las personas que necesitan agún servicio, primero lo buscan en su internet,
                        el otro <strong>20%</strong> consultan la recomendación de un familiar sobre negocio o servicio <br>
                        ¡Deja que ese <strong>80%</strong> te encuentre de una manera más sencilla!

                    </p>

                    <!-- CTA -->
                    <a href="<?php echo $RUTA; ?>registro" class="btn btn-indigo btn-md">Registrarme
                        <i class="fas fa-users-cog mx-3"></i>
                    </a>
                    <a href="<?php echo $RUTA; ?>login" class="btn btn-indigo btn-md">Iniciar Sesión
                        <i class="fas fa-sign-in-alt mx-3"></i>
                    </a>

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

        </section>
        <!--Section: Main info-->

        <hr class="my-5">

    </div>

    <?php $TEMPLATES->footer(); ?>
    <?php $TEMPLATES->scripts(); ?>
</body>

</html>