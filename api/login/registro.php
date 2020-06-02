<?php

use App\Config\Config;
use App\Email\Email;
use App\Models\{Administrador, Clientes};

$CONFIG = new Config();
$ADMIN = new Administrador();

switch ($_POST['opcion']) {
    case 'registro':
        $nombre  = isset($_POST['nombre']) && !empty($_POST['nombre']) ? $_POST['nombre'] : false;
        $apellidos  = isset($_POST['apellidos']) && !empty($_POST['apellidos']) ? $_POST['apellidos'] : false;
        $correo  = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : false;
        $password  = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : false;
        $password_r  = isset($_POST['password_r']) && !empty($_POST['password_r']) ? $_POST['password_r'] : false;
        $captcha  = isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;
        $CLIENTES = new Clientes();
        $CLIENTES->CONEXION = $CONFIG->getConexion();
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

        if ($nombre && $apellidos && $correo && $password && $password_r) {
            $USUARIO = $CLIENTES->encontrarCorreo($correo);
            if (!$USUARIO) {
                if ($password == $password_r) {
                    $CLIENTES->nombre = $nombre;
                    $CLIENTES->apellidos = $apellidos;
                    $CLIENTES->correo = $correo;
                    $CLIENTES->password = md5($password);
                    $CLIENTES->estado = 'pendiente';
                    $CLIENTES->code = $ADMIN->generarCodigo(3) . '-' . $ADMIN->generarCodigo(4);
                    if ($cliente_id = $CLIENTES->crearCliente()) {
                        $respuesta = array(
                            'respuesta' => 'exito',
                            'Texto' => 'Fuiste registrado de manera correcta, revisa tu bandeja y valida tu cuenta para continuar comprando', $USUARIO
                        );
                    } else {
                        $respuesta = array(
                            'respuesta' => 'error',
                            'Texto' => 'Por el momento no se pueden realizar más registros'
                        );
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Las contraseñas no coinciden', $USUARIO
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'El correo que intenta registrar ya existe en nuestro sistema',
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'Es necesario que completes todos los campos', $_POST
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
