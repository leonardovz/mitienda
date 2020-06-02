<?php

use App\Config\Config;
use App\Email\Email;
use App\Models\{Clientes, Usuarios};

$CONFIG = new Config();

switch ($_POST['opcion']) {
    case 'login':
        $correo     = isset($_POST['correo'])   && !empty($_POST['correo']) ? $_POST['correo'] : false;
        $password   = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : false;
        $tipo       = isset($_POST['tipo'])     && !empty($_POST['tipo']) ? $_POST['tipo'] : false;
        $captcha  = isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;
        $USUARIOS = false;
        if ($tipo === 'administrador') {
            $USUARIOS = new Usuarios();
        } else {
            $USUARIOS = new Clientes();
        }
        $tipo_u = $tipo === 'administrador' ? true : false;
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
                    $_SESSION[$CONFIG->sessionName()]['correo'] = $tipo_u ? $USUARIO['correo']:$USUARIO['email'];
                    $_SESSION[$CONFIG->sessionName()]['cargo'] = $tipo_u ? $USUARIO['cargo'] : 'cliente';
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
                    'Texto' => 'Correo o contraseña no son correctos',$_POST
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
    case 'verificacion':
        $correo  = isset($_POST['correo']) && !empty($_POST['correo']) ? $_POST['correo'] : false;
        $codigo  = isset($_POST['codigo']) && !empty($_POST['codigo']) ? $_POST['codigo'] : false;
        $captcha  = isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;
        $CLIENTES = new Clientes();
        if ($correo) {
            if ($cliente = $CLIENTES->encontrarCorreo($correo)) {
                if ($cliente['estado'] != 'pendiente') {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Tu cuenta ya ha sido verificada tu usuario se encuentra: ' . $cliente['estado'],
                    );
                } else if ($cliente['activacion'] != $codigo) {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'El código de verificación no es correcto',
                    );
                } else if ($cliente['estado'] == 'pendiente') {
                    $CLIENTES->cambiar_estado_cliente($cliente['id'], 'activo');
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Tu cuenta ha sido verificada',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Ocurrio un error al querer al activar tu cuenta',
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'El correo que intentas validar no existe',
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
    default:
        # code...
        break;
}
