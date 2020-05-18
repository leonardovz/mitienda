<?php

use App\Models\{Templates, Administrador};
use App\Models\{Usuarios};


$TEMPLATES = new Templates();
$ADMIN = new Administrador();
$USER = new Usuarios();

// $user_info = $USER->traer_info_perfil($USERSYSTEM['idUsuario'], $USERSYSTEM['giro']);

$TEMPLATES->TITULO =      'Completar compra  | ' . $TEMPLATES->SISTEMNAME;
$TEMPLATES->DESCRIPCION = 'Registrar mi compra | ' . $TEMPLATES->DESCRIPCION;
$TEMPLATES->KEYWORDS =    'Finalizar compra | ' . $TEMPLATES->KEYWORDS;

$TEMPLATES->header();
// $fecha = date('d') . ' de ' . $ADMIN->MESES((int) date('m')) . ' de ' . date('Y');
?>

<body>
    <header class="site-navbar site-navbar-target pb-0" role="banner">
        <?php echo $TEMPLATES->navBar('carrito', $USERSYSTEM); ?>
    </header>
    <div class="container mt-5">
        <div class="row">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Nota:</h5>
                Esta página es solamente para la confirmación de su pedido,
                una vez procesado su encargo, será responsabilidad de la tienda o el repartidor entregar los productos.
            </div>
        </div>
    </div>
    <div class="container" style="min-width: 1000px">
        <div class="row">
            <div class="col-12 table-responsive">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> <?php echo $TEMPLATES->SISTEMNAME; ?>.
                                <small class="float-right"><?php echo $fecha; ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Para:
                            <address>
                                <strong><?php echo $USERSYSTEM['nombre'] . ' ' . $USERSYSTEM['apellidos']; ?></strong><br>
                                Colonia:<?php echo $user_info['colonia']; ?><br>
                                Dirección:<?php echo $user_info['domicilio']; ?><br>
                                Teléfono:<?php echo $user_info['domicilio']; ?><br>

                                Correo: <?php echo $USERSYSTEM['correo']; ?>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive" id="table_carrito">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="lead">Método de pago:</p>
                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                El pago de el pedido debe de ser al recibir los productos.
                            </p>
                            <p id="alerta_vendedor">

                            </p>
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Productos:</th>
                                        <td id="total_productos">0</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Total:</th>
                                        <td id="total_compra">$0.00</td>
                                    </tr>
                                    <tr>s
                                        <th>Envío:</th>
                                        <td>Acordar con el vendedor</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container">
        <div class="row mb-5 pb-5">
            <div class="col-12 table-responsive">
                <div class="invoice p-3 mb-3">
                    <div class="row justify-content-end pb-5">
                        <div class="col-md-5">
                            <h4>Selecciona la manera en la que quieres recibir tu pedido</h4>
                            <form id="enviar_pedido">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="yo_ire" name="envio_control" value="yo" checked>
                                    <label class="custom-control-label" for="yo_ire">Paso por el</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="envio_vendedor" name="envio_control" value="vendedor">
                                    <label class="custom-control-label" for="envio_vendedor">Que el vendedor me lo envíe</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="trae_repartidor" name="envio_control" value="repartidor">
                                    <label class="custom-control-label" for="trae_repartidor">Repartidor</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="comentario" name="comentario" class="form-control" maxlength="250">
                                    <label for="comentario">Agregar comentario</label>

                                </div>
                                <button type="submit" class="btn btn-primary float-right no-print mr-2"> <i class="fas fa-receipt"></i> Realizar mi pedido </button>

                            </form>
                        </div>
                    </div>
                    <div class="row no-print">
                        <div class="col-12">
                            <a class="btn btn-default" id="print_nota"><i class="fas fa-print"></i> Imprimir</a>
                            <a href="<?php echo $RUTA; ?>carrito" class="btn btn-warning float-right no-print"><i class="fab fa-opencart"></i> Volver</a>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <?php //$TEMPLATES->footer(); 
    ?>

    <?php $TEMPLATES->scripts(); ?>
    <script>
        $(document).ready(function() {
            $("#print_nota").on('click', function() {
                window.addEventListener("load", window.print());
            })
        });
    </script>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/carrito/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/carrito/pedido.js"></script>

</body>

</html>