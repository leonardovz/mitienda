<?php

$LT = sizeof($DIRECTORIO);
if ($LT == 1) {
    require_once '../views/clientes/perfil/perfil.view.php';
}
/**
 * Apartado
 */
else if ($LT == 2 && $DIRECTORIO[1] == "mispedidos") {
    require_once '../views/clientes/pedidos/pedidos.view.php';
}
/**
 * Apartado
 */
else if ($LT == 2 && $DIRECTORIO[1] == "productos" && $LT == 2) {
    require_once '../views/sistema/productos/productos.view.php';
}
