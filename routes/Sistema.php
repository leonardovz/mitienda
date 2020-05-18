<?php
$LT = sizeof($DIRECTORIO);
if ($LT == 1) {
    require_once '../views/sistema/productos/productos.view.php';
}
/**
 * Apartado
 */
else if ($DIRECTORIO[1] == "categorias" && $LT == 2) {
    require_once '../views/sistema/categorias/categorias.view.php';
}
/**
 * Apartado
 */
else if ($DIRECTORIO[1] == "productos" && $LT == 2) {
    require_once '../views/sistema/productos/productos.view.php';
}
/**
 * Apartado
 */
else if ($DIRECTORIO[1] == "productos" && ($LT == 3 || $LT == 4) && (int) $DIRECTORIO[2] > 0) {
    $idProducto = (int) $DIRECTORIO[2];
    require_once '../views/sistema/productos/productos.edit.php';
}
/**
 * Apartado
 */
else if ($DIRECTORIO[1] == "usuarios" && $LT == 2) {
    require_once '../views/sistema/usuarios/usuarios.view.php';
}
/**
 * Apartado
 */
else if ($DIRECTORIO[1] == "pedidos" && $LT == 2) {
    require_once '../views/sistema/pedidos/pedidos.view.php';
}
/**
 * Apartado
 */
else if ($DIRECTORIO[1] == "account" && $LT == 2) {
    require_once '../views/sistema/account/account.view.php';
}
/**
 * Apartado
 */
else if ($LT = 3 && $DIRECTORIO[1] == "account" && (int) $DIRECTORIO[2] > 0 && $USERSYSTEM['cargo'] == 'administrador') {
    $idUsuario = (int) $DIRECTORIO[2];
    require_once '../views/sistema/account/account.edit.php';
} else {
    require_once("../views/errors/error.view.php");
}
