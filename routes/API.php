<?php
$LT = sizeof($DIRECTORIO);
if ($LT == 2 && $DIRECTORIO[1] == "login") {
    require_once '../api/login/login.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "registro") {
    require_once '../api/login/registro.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "verificacion") {
    require_once '../api/login/login.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "clientes") {
    require_once '../api/clientes/clientes.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "categorias") {
    require_once '../api/categorias/categorias.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "notas") {
    require_once '../api/notas/notas.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "usuarios") {
    require_once '../api/usuarios/usuarios.php';
}
/**APARTADO */

else if ($LT == 2 && $DIRECTORIO[1] == "productos") {
    require_once '../api/productos/productos.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "pedidos") {
    require_once '../api/pedidos/pedidos.php';
}
/**APARTADO */

else if ($LT == 2 && $DIRECTORIO[1] == "carrito") {
    require_once '../api/carrito/carrito.php';
}
/**APARTADO */

else if ($LT == 2 && $DIRECTORIO[1] == "procesar_pago") {
    require_once '../api/pagos/procesar_pago.php';
}
/**APARTADO */
else if ($LT == 2 && $DIRECTORIO[1] == "index") {
    require_once '../api/index/ajax.php';
}
/**APARTADO */
else {
    die(json_encode(['respuesta' => 'error', 'Texto' => 'Peticion no es correcta', $_POST, $_SERVER, $DIRECTORIO]));
}
