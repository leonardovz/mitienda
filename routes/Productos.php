<?php
$LT = sizeof($DIRECTORIO);
$filtro_buscar = false;
if ($LT == 1) {
    require_once '../views/productos/productos.view.php';
} else if (($LT == 2 && $LT == 2 ||  $LT == 3) && (int) $DIRECTORIO[1] > 0) {
    $idProducto = (int) $DIRECTORIO[1];
    require_once '../views/productos/producto_vista.view.php';
} else {
    require_once("views/errors/error.view.php");
}
