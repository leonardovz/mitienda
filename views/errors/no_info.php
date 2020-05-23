<?php

use App\Models\Templates;

$TEMPLATES = new Templates();

$TEMPLATES->header();

?>

<body>
    <!-- Main navigation -->
    <header class="mb-5">
        <!--Navbar-->
        <?php $TEMPLATES->navBar('carrito',$USERSYSTEM); ?>
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
                    <p>Para continuar es necesario que completes los datos de tu perfil
                        <strong><?php echo $TEMPLATES->SISTEMNAME; ?></strong> .</p>
                    <p>Permite a las personas que sepan quién les esta comprando, danos tus datos de contacto para poder realizar envíos a tu domicilio</p>
                    <!-- Main heading -->

                    <hr>


                    <!-- CTA -->
                    <a href="<?php echo $RUTA; ?>sistema/config" class="btn btn-indigo btn-md">Completar mi perfil
                        <i class="fas fa-users-cog mx-3"></i>
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