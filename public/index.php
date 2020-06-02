<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

session_start();

require_once("../app/controller.php");

use App\Config\{Config};

$CONFIG = new Config();
$RUTA = $CONFIG->RUTA();

$route = str_replace($CONFIG->route(), "", $_SERVER["REQUEST_URI"]); //Obtiene la carpeta donde esta el proyecto
$URI_REQUEST = explode("?", $route)[0]; //Separa los elementos $_GET
// echo $URI_REQUEST;

$DIRECTORIO = isset($URI_REQUEST) ? explode('/', $URI_REQUEST) : false; //Configura y limpia la URI
$USERSYSTEM = isset($_SESSION[$CONFIG->sessionName()]) ? $_SESSION[$CONFIG->sessionName()] : false;
if ($DIRECTORIO) {
    $dirArray = [];
    foreach ($DIRECTORIO as $key => $value) {
        if ($DIRECTORIO[$key] != '') {
            $dirArray[] = $DIRECTORIO[$key];
        }
    }
    $DIRECTORIO = $dirArray;
}
/**
 * CONTROLADOR raiz
 */
if (!$DIRECTORIO) {
    require_once("../views/index/index.view.php");
}
/**
 * PRODUCTOS
 */
else if ($DIRECTORIO[0] == "productos") {
    require_once '../routes/Productos.php';
}

/**
 * CONTROLADOR LOGIN OPTIONS
 */
else if ($DIRECTORIO[0] == "login" || $DIRECTORIO[0] == "registro" || $DIRECTORIO[0] == "recuperar" || $DIRECTORIO[0] == "verificar" || $DIRECTORIO[0] ==  'recuperarcuenta') {

    if (!$USERSYSTEM) {
        require_once '../routes/Login.php';
    } else {
        header('Location: ' . $RUTA . 'sistema');
    }
}

/**
 * APARTADO ADMINISTRADORES DEL SISTEMA
 */
else if ($DIRECTORIO[0] == "sistema") {

    if ($USERSYSTEM && $USERSYSTEM['cargo'] != 'cliente') {
        require_once '../routes/Sistema.php';
    } else if ($USERSYSTEM && $USERSYSTEM['cargo'] == 'cliente') {
        require_once '../routes/Clientes.php';
    } else {
        session_reset();
        header('Location:' . $RUTA . 'login');
    }
}

/**
 * CONTROLADOR LOGIN OPTIONS
 */
else if ($DIRECTORIO[0] == "carrito") {
    require_once '../routes/Carrito.php';
}
/**
 * Aquí consumimos la api o backend
 */
else if ($DIRECTORIO[0] == "back" && $_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../routes/API.php';
}

/**
 * CONTROLADOR LOGIN OPTIONS
 */

/**
 * ERROR  APARTADOS ERRONEOS
 */
else {
    echo json_encode($DIRECTORIO);
    die(json_encode($_POST));
    // require_once("views/errors/error.view.php");
}
