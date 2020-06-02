<?php

use App\Models\{Templates};


$TEMPLATES = new Templates();
$TEMPLATES->TITULO =      'Carrito de compras  | ' . $TEMPLATES->SISTEMNAME;
$TEMPLATES->DESCRIPCION = 'Crear mi pedido | ' . $TEMPLATES->DESCRIPCION;
$TEMPLATES->KEYWORDS =    'Carrito de compras | ' . $TEMPLATES->KEYWORDS;


$TEMPLATES->header();
?>

<body class="unique-color">
    <header class="site-navbar site-navbar-target pb-0" role="banner">
        <?php echo $TEMPLATES->navBar('carrito', $USERSYSTEM); ?>
    </header>
    <div class="container z-depth-1 pt-5 my-5 ">
        <section>
            <div class="row">

                <div class="col-md-12 mb-4 text-center">
                    <br>
                    <h2> Carrito de compras </h2>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="cont_wish_list">

                </div>
            </div>
            <hr class="bg-white ">
            <div class="row py-3 bg-white">
                <div class="col-md-12 text-right">
                    <p class="h6"><span>Productos</span> <strong id="total_productos">0</strong></p>
                    <p class="h4"><span>Total</span> <strong id="total_compra">$ 0.00</strong></p>
                </div>
                <div class=" col-md-12">
                    <a href="<?php echo $RUTA; ?>carrito/comprar" class="btn btn-primary btn-rounded px-4">Completar pedido
                        <i class="fas fa-angle-right right"></i>
                    </a>
                </div>
            </div>
        </section>
        <!-- Section: Block Content -->

    </div>
    <?php $TEMPLATES->footer(); ?>

    <?php $TEMPLATES->scripts(); ?>

    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/models/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/carrito/carrito.js"></script>

</body>

</html>