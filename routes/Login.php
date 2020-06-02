<?php
$LT = sizeof($DIRECTORIO);
if ($LT <= 2 && $DIRECTORIO[0] == "login") {
    $_log_admin = (isset($DIRECTORIO[1]) && $DIRECTORIO[1] == 'admin') ? true : false;
    require_once '../views/login/login.view.php';
}
/**Registro */
else if ($DIRECTORIO[0] == "registro" && $LT == 1) {
    require_once '../views/login/registro.view.php';
    // } else if ($DIRECTORIO[0] == "recuperarcuenta" && $LT == 1) {
    //     require_once '../views/login/recuperar.view.php';
} else if ($DIRECTORIO[0] == "verificar" && $LT < 3) {
    $idCodigo = isset($DIRECTORIO[1]) ? (int) $DIRECTORIO[1] : false;
    require_once '../views/login/verificar.view.php';
} else {
    require_once("../views/errors/error.view.php");
}
