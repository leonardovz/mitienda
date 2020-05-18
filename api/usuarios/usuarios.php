<?php

use App\Config\Config;
use App\Models\{Usuarios, Administrador};

$CONFIG = new Config();
$ADMIN = new Administrador();
$opcion = isset($_POST['opcion']) ? htmlspecialchars($_POST['opcion']) : false;

switch ($opcion) {
    case 'mostrar':
        $tipo  = (isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] == 'system') ? 'inactivo' : 'activo';
        // $tipo  = (isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] == 'system') ? 'inactivo' : 'activo';
        // $tipo  = (isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] == 'system') ? 'inactivo' : 'activo';
        // $tipo  = (isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] == 'system') ? 'inactivo' : 'activo';
        // $tipo  = (isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] == 'system') ? 'inactivo' : 'activo';
        $USUARIOS = new Usuarios();
        if (!$USERSYSTEM && ($USERSYSTEM && $USERSYSTEM['cargo'] != 'administrador')) {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 401,
                'Texto' => 'No tienes permisos para acceder a las funciones',
                'usuarios' => $usuariosArray,
            );
        } else if ($resultado = $USUARIOS->traerUsuarios($tipo)) {
            $usuariosArray = [];
            while ($usuario = $resultado->fetch_assoc()) {
                $usuariosArray[] = array(
                    'usuario' => $usuario,
                );
            }
            $respuesta = array(
                'respuesta' => 'exito',
                'Texto' => 'Usuarios encontradas',
                'usuarios' => $usuariosArray,
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No existen usuarios'
            );
        }
        die(json_encode($respuesta));
        break;
    case 'crear':

        $nombre     = isset($_POST['nombre'])     && !empty($_POST['nombre'])     ? $_POST['nombre'] : false;
        $apellidos  = isset($_POST['apellidos'])  && !empty($_POST['apellidos'])  ? $_POST['apellidos'] : false;
        $correo     = isset($_POST['correo'])     && !empty($_POST['correo'])     ? $_POST['correo'] : false;
        $tipo_user  = isset($_POST['tipo_user'])  && !empty($_POST['tipo_user'])  ? $_POST['tipo_user'] : false;

        $USUARIOS = new Usuarios();
        if (!$nombre || !$apellidos || !$correo || !$tipo_user) {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'Es necesario que completes todos los campos'
            );
        } else if ($USERSYSTEM) {
            $resultado = $USUARIOS->encontrarCorreo($correo);
            if (!$resultado) {

                $password = $ADMIN->generarPassword(10); //Contraseña creada aleatoriamente

                $USUARIOS->nombre = $nombre;
                $USUARIOS->apellidos = $apellidos;
                $USUARIOS->correo = $correo;
                $USUARIOS->password = md5($password);
                $USUARIOS->estado = 'activo';
                $USUARIOS->cargo = $tipo_user;
                if ($total = $USUARIOS->contarUsuarios() > 5) {
                    die(json_encode(array(
                        'respuesta' => 'error',
                        'Texto' => 'No es posible registrar más usuarios, superaste el limite establecido',
                    )));
                }
                $res_usuario = $USUARIOS->crearUsuario($nombre);
                if ($res_usuario) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Usuario creado de manera exitosa',
                        'pass' => $password,
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Por el momento no es posible registrar una nueva usuario'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'El correo que intentas registrar ya existe'
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No puedes realizar la acción que requieres',
            );
        }
        die(json_encode($respuesta));
        break;
    case 'editar':
        $nombre  = isset($_POST['nombre']) && !empty($_POST['nombre']) ? $_POST['nombre'] : false;
        $id  = isset($_POST['id']) && !empty($_POST['id']) ? (int) $_POST['id'] : false;
        $estado  = isset($_POST['estado']) && !empty($_POST['estado']) ? $_POST['estado'] : false;

        $USUARIOS = new Usuarios();
        $USUARIOS->CONEXION = $CONFIG->getConexion();
        if ($USERSYSTEM) {
            if (!$nombre || !$estado || !$id) {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No llegaron los datos de manera correcta'
                );
            } else {
                $res_usuario = $USUARIOS->actualizarUsuario($id, $nombre, $estado);
                if ($res_usuario) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Usuario creada de manera exitosa'
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'No fue posible realizar Cambios', $res_usuario
                    );
                }
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'Es necesario que completes todos los campos',
            );
        }
        die(json_encode($respuesta));
        break;

    case 'actualizar_datos':
        if ($USERSYSTEM && $USERSYSTEM['cargo'] == 'administrador') {
            $USUARIOS = new Usuarios();

            $apellidos = isset($_POST['apellidos']) && !empty($_POST['apellidos']) ? $_POST['apellidos'] : false;
            $correo =    isset($_POST['correo'])    && !empty($_POST['correo'])    ? $_POST['correo'] : false;
            $idUsuario = isset($_POST['idUsuario']) && !empty($_POST['idUsuario']) ? $_POST['idUsuario'] : false;
            $nombre =    isset($_POST['nombre'])    && !empty($_POST['nombre'])    ? $_POST['nombre'] : false;
            $rango = isset($_POST['rango']) && !empty($_POST['rango']) ? $_POST['rango'] : false;


            $USUARIOS->id = $idUsuario;
            $USUARIOS->nombre = $nombre;
            $USUARIOS->apellidos = $apellidos;
            $USUARIOS->correo = $correo;
            $USUARIOS->cargo = $rango;

            if ($apellidos && $correo && $idUsuario && $nombre) {
                if ($usuario = $USUARIOS->buscarUsuario($idUsuario)) {
                    if ($correo == $usuario['correo']) {
                        if ($USUARIOS->actualizarUsuario()) {
                            $respuesta = array(
                                'respuesta' => 'exito',
                                'Texto' => 'Los datos fueron actualizados',
                                $_POST
                            );
                        } else {
                            $respuesta = array(
                                'respuesta' => 'error',
                                'Texto' => 'No se realizaron cambios',
                                $_POST
                            );
                        }
                    } else {
                        if (($correo != $usuario['correo'] && $USUARIOS->encontrarCorreo($correo))) {
                            $respuesta = array(
                                'respuesta' => 'error',
                                'Texto' => 'El correo ya esta registrado',
                                $_POST
                            );
                        } else {
                            if ($USUARIOS->actualizarUsuario()) {
                                $respuesta = array(
                                    'respuesta' => 'exito',
                                    'Texto' => 'Los datos fueron actualizados',
                                    $_POST
                                );
                            } else {
                                $respuesta = array(
                                    'respuesta' => 'error',
                                    'Texto' => 'No se realizaron cambios',
                                    $_POST
                                );
                            }
                        }
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'El usuario no se encuentra',
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'Es necesario que completes todos los campos',
                    $_POST
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
    case 'reset_password':
        $idUsuario  = isset($_POST['idUsuario'])  && !empty($_POST['idUsuario'])  ? $_POST['idUsuario'] : false;

        if ($USERSYSTEM && $USERSYSTEM['cargo'] == 'administrador') {
            $USUARIOS = new Usuarios();
            if ($usuario = $USUARIOS->buscarUsuario($idUsuario)) {
                $password = $ADMIN->generarPassword(10); //Contraseña creada aleatoriamente
                $USUARIOS->id = $idUsuario;
                $USUARIOS->password = md5($password);
                if ($USUARIOS->actualizar_password()) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Tu nueva contraseña es: ' . $password
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'No fue posible Actualizar la contraseña'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No se encontro el usuario',
                    'error' => 301,
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permisos para acceder',
                'error' => 401,
            );
        }
        die(json_encode($respuesta));
        break;
    case 'change_password':
        $password       = isset($_POST['password'])       && !empty($_POST['password'])      ? $_POST['password'] : false;
        $new_password   = isset($_POST['new_password'])   && !empty($_POST['new_password'])  ? $_POST['new_password'] : false;
        $r_new_password = isset($_POST['r_new_password']) && !empty($_POST['r_new_password']) ? $_POST['r_new_password'] : false;

        if ($USERSYSTEM) {
            $idUsuario  = $USERSYSTEM['idUsuario'];
            $USUARIOS = new Usuarios();
            if ($usuario = $USUARIOS->buscarUsuario($idUsuario)) {
                if ($new_password != $r_new_password) {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Tus nuevas contraseñas no coinciden: ' . $password
                    );
                } else if ($password == $new_password) {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Tu contraseña anterior es igual a la que quieres cambiar: ' . $password
                    );
                } elseif ($usuario['password'] == md5($password)) {
                    $USUARIOS->id = $idUsuario;
                    $USUARIOS->password = md5($new_password);
                    if ($USUARIOS->actualizar_password()) {
                        $respuesta = array(
                            'respuesta' => 'exito',
                            'Texto' => 'Contraseña cambiada de forma exisosa'
                        );
                    } else {
                        $respuesta = array(
                            'respuesta' => 'error',
                            'Texto' => 'No fue posible Actualizar la contraseña'
                        );
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'La contraseña actual no coincide con los registros'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No se encontro el usuario',
                    'error' => 301,
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permisos para acceder',
                'error' => 401,
                $_POST
            );
        }
        die(json_encode($respuesta));
        break;
    case 'block_user':
        $idUsuario  = isset($_POST['idUsuario'])  && !empty($_POST['idUsuario'])  ? $_POST['idUsuario'] : false;

        if ($USERSYSTEM && $USERSYSTEM['cargo'] == 'administrador') {
            $USUARIOS = new Usuarios();
            if ($usuario = $USUARIOS->buscarUsuario($idUsuario)) {
                $USUARIOS->id = $idUsuario;
                $USUARIOS->estado = $usuario['estado'] == 'activo' ? 'inactivo' : 'activo';
                if ($USUARIOS->actualizar_estado()) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Se actualizo el estado: ',
                        'estado' => $USUARIOS->estado
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'No fue posible Actualizar la contraseña'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No se encontro el usuario',
                    'error' => 301,
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permisos para acceder',
                'error' => 401,
            );
        }
        die(json_encode($respuesta));

        break;
    default:
        # code...
        break;
}
