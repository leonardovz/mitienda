<?php
$LT = sizeof($DIRECTORIO);
if ($LT > 0 && $LT < 4) {
    if ($DIRECTORIO[0] == "planes" && $LT == 1) {
        $idUsuario  = isset($DIRECTORIO[1]) ? (int) $DIRECTORIO[1] : false;
        require_once 'views/planes/planes.view.php';
    }
    /**
     * ACTIVACION DEL PAQUETE
     */
    else if ($DIRECTORIO[0] == "planes" && $LT > 1 && $LT < 4) {
        $idPaquete  = isset($DIRECTORIO[1]) ? (int) $DIRECTORIO[1] : false;
        if ($USERSYSTEM['perfil_completo'] == true) {
            require_once 'views/planes/planes_activar.view.php';
        } else {
            require_once("views/errors/no_info.php");
        }
    } else {
        require_once("views/errors/error.view.php");
    }
} else {
    require_once("views/errors/error.view.php");
}
