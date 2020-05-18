<?php
$LT = sizeof($DIRECTORIO);
if ($LT < 4) {
    if ($LT == 1 && $DIRECTORIO[0] == "carrito") {
        require_once '../views/carrito/carrito.view.php';
    } else if ($LT == 2 && $DIRECTORIO[1] == "comprar") {
        if ($USERSYSTEM) {
            if ($USERSYSTEM['perfil_completo']) {
                require_once '../views/carrito/carrito_compra.view.php';
            } else {
                require_once("../views/errors/no_info.php");
            }
        } else {
            require_once("../views/errors/no_login.php");
        }
    } else if ($LT == 3 && $DIRECTORIO[1] == "ticket") {
        if ($USERSYSTEM) {
            $id_Venta = (int) $DIRECTORIO[2];
            require_once '../app/tickets/Factura.php';
        } else {
            require_once("../views/errors/no_login.php");
        }
    } else {
        header("Location:" . $RUTA . 'productos');
    }
} else {
    require_once("../views/errors/error.view.php");
}
