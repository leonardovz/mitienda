<?php

use App\Models\{Templates};

$TEMPLATES = new Templates();
$TEMPLATES->USERSYSTEM = $USERSYSTEM;

$TEMPLATES->cropper = true;
$TEMPLATES->adminLTE = true;
$TEMPLATES->header(); ?>

<body>
    <!-- Main navigation -->
    <div class="wrapper">
        <header class="">
            <?php
            $TEMPLATES->navAdmin();
            $TEMPLATES->sideBarAdmin('mispedidos', $USERSYSTEM);
            ?>
        </header>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col" id="paginacion"></div>
                                    <div class="col">
                                        <select class="browser-default custom-select" id="estado_pedido">
                                            <option value="">Filtro de Estado de pedido</option>
                                            <option value="pendiente">Pendiente</option>
                                            <option value="cancelado">Cancelado</option>
                                            <option value="aceptado">Aceptado</option>
                                            <option value="enviado">Enviado</option>
                                            <option value="pedido_listo">Pedido listo</option>
                                            <option value="recibido">Recibido</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive " id="content_pedidos">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $TEMPLATES->scripts(); ?>
    <script src="<?php echo $RUTA; ?>views/sistema/pedidos/script/mis_pedidos.js"></script>
    <script src="<?php echo $RUTA; ?>views/sistema/pedidos/script/config.js"></script>
    <script src="<?php echo $RUTA; ?>library/js/funciones.js"></script>

</body>

</html>