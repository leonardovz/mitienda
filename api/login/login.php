<?php

use App\Config\Config;
use App\Email\Email;
use App\Models\{Usuarios};

$CONFIG = new Config();

switch ($_POST['opcion']) {
    case 'login':
        $correo  = isset($_POST['correo']) && !empty($_POST['correo']) ? $_POST['correo'] : false;
        $password  = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : false;
        $captcha  = isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;
        $USUARIOS = new Usuarios();
        $USUARIOS->CONEXION = $CONFIG->getConexion();
        /** */
        // if ($captcha) {

        //     $secret = '6LdHtOEUAAAAALkjmkoeaD-NE1_uuyEFvxk70w6f';

        //     if (!$captcha) {
        //         die(json_encode(array(
        //             'respuesta' => 'error',
        //             'Texto' => 'Por favor verifica el captcha', $_POST
        //         )));
        //     } else {

        //         $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");

        //         $arr = json_decode($response, TRUE);

        //         if ($arr['success']) {
        //             // echo '<h2>Thanks</h2>';
        //         } else {
        //             die(json_encode(array(
        //                 'respuesta' => 'error',
        //                 'Texto' => 'No se capturo de forma correcta el captcha',
        //             )));
        //         }
        //     }
        // } else {
        //     die(json_encode(array(
        //         'respuesta' => 'error',
        //         'Texto' => 'Debes de completar el capcha', $_POST
        //     )));
        // }

        if ($correo) {
            if ($USUARIO = $USUARIOS->encontrarCorreo($correo)) {
                if ($USUARIO && $USUARIO['estado'] == 'inactivo') {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Tu cuenta se encuentra inactiva',
                    );
                } else if ($USUARIO['password'] == md5($password)) {
                    $_SESSION[$CONFIG->sessionName()]['idUsuario'] = $USUARIO['id'];
                    $_SESSION[$CONFIG->sessionName()]['nombre'] = $USUARIO['nombre'];
                    $_SESSION[$CONFIG->sessionName()]['apellidos'] = $USUARIO['apellidos'];
                    $_SESSION[$CONFIG->sessionName()]['correo'] = $USUARIO['correo'];
                    $_SESSION[$CONFIG->sessionName()]['cargo'] = $USUARIO['cargo'];
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Sesión creada de manera correcta',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Correo o contraseña no son correctos',
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'Correo o contraseña no son correctos',
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'Es necesario que completes todos los campos',
            );
        }
        die(json_encode($respuesta));
        break;


    case 'cerrarSesion':
        if (session_destroy()) {
            $respuesta = array(
                'respuesta' => 'exito',
                'Texto' => 'Cerrando Sesión',
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'Intenta cerrar de nuevo o recarga la página',
            );
        }
        die(json_encode($respuesta));
        break;
    default:
        # code...
        break;
}
