<?php

use App\Models\Templates;

$TEMPLATE = new Templates();


$TEMPLATE->owlCarousel = true;
$TEMPLATE->header();
?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->navBar(); ?>

        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url('<?php echo $RUTA; ?>galeria/bg/bg.png') no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" style="color:#FFF;" href="<?php echo $RUTA; ?>">Home</a>
                                    <span class="brd-separetor"><i class="zmdi zmdi-chevron-right" style="color:#FFF;"></i></span>
                                    <span class="breadcrumb-item active" style="color:#FFF;">Productos</span>
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
                    <div class="col-lg-9 col-lg-push-3 col-md-9 col-md-push-3 col-sm-12 col-xs-12">
                        
                        <div class="htc__product__container">
                            <div class="row">
                                <div class="product__list clearfix mt--30" id="container_productos">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 " id="paginacion">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-pull-9 col-md-3 col-md-pull-9 col-sm-12 col-xs-12 smt-40 xmt-40">
                        <div class="htc__product__leftsidebar">
                            <!-- Start Prize Range -->
                            <div class="htc-grid-range">
                                <h4 class="title__line--4">Precio</h4>
                                <div class="content-shopby">
                                    <div class="price_filter s-filter clear">
                                        <form id="filtrar_costo" action="" method="GET">
                                            <div id="slider-range"></div>
                                            <div class="slider__range--output">
                                                <div class="price__output--wrap">
                                                    <div class="price--output">
                                                        <input type="hidden" id="search_filter" value="<?php echo (isset($_GET['q']) ? $_GET['q'] : ""); ?>">
                                                        <input type="hidden" id="categoria" value="<?php echo (isset($_GET['categoria']) ? $_GET['categoria'] : ""); ?>">
                                                        <span>Precio :</span><input type="text" id="amount" name="filtro_precio" readonly>
                                                    </div>
                                                    <div class="price--filter">
                                                        <a href="#" id="filter_price">Filtrar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Prize Range -->
                            <!-- Start Category Area -->
                            <div class="htc__category">
                                <h4 class="title__line--4">Categorias</h4>
                                <ul class="ht__cat__list" id="categorias_list">
                                    <li><a href="#">Dama</a></li>
                                    <li><a href="#">Vestidos</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php $TEMPLATE->footer(); ?>
    </div>

    <?php $TEMPLATE->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/productos.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/paginacion.js"></script>
    <script src="<?php echo $RUTA; ?>js/index/productos/productos.js"></script>
</body>