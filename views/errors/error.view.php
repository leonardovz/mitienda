<?php

use App\Models\Templates;

$TEMPLATE = new Templates();


$TEMPLATE->owlCarousel = true;
$TEMPLATE->header();
?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->navBar(); ?>

        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url('<?php echo $RUTA; ?>library/asbab/images/bg/4.jpg') no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Home</a>
                                    <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                    <span class="breadcrumb-item active">Products</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="htc__product__grid bg__white ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Opss</h2>
                        <p>Acabas de ingresar a un apartado que no existe o no tienes permisos para acceder</p>
                    </div>
                </div>
            </div>
        </section>
        <?php $TEMPLATE->footer(); ?>
    </div>

    <?php $TEMPLATE->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/models/productos.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/paginacion.js"></script>
    <script src="<?php echo $RUTA; ?>js/productos/productos.js"></script>
</body>