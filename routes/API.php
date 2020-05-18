<?php
$LT = sizeof($DIRECTORIO);
if ($LT == 2 && $DIRECTORIO[1] == "login") {
    require_once '../api/login/login.php';
}
/**APARTADO */
if ($LT == 2 && $DIRECTORIO[1] == "clientes") {
    require_once '../api/clientes/clientes.php';
}
/**APARTADO */
if ($LT == 2 && $DIRECTORIO[1] == "categorias") {
    require_once '../api/categorias/categorias.php';
}
/**APARTADO */
if ($LT == 2 && $DIRECTORIO[1] == "notas") {
    require_once '../api/notas/notas.php';
}
/**APARTADO */
if ($LT == 2 && $DIRECTORIO[1] == "usuarios") {
    require_once '../api/usuarios/usuarios.php';
}
if ($LT == 2 && $DIRECTORIO[1] == "productos") {
    require_once '../api/productos/productos.php';
}
if ($LT == 2 && $DIRECTORIO[1] == "pedidos") {
    require_once '../api/pedidos/pedidos.php';
}
/**APARTADO */
if ($LT == 2 && $DIRECTORIO[1] == "index") {
    require_once '../api/index/ajax.php';
}
/**APARTADO */
