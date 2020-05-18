<?php

use App\Config\Config;
use App\Models\{Categorias};

$CONFIG = new Config();
$opcion = isset($_POST['opcion']) ? htmlspecialchars($_POST['opcion']) : false;

switch ($opcion) {
    case 'mostrar':
        $tipo  = (isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] == 'system') ? false : true;
        $CATEGORIAS = new Categorias();
        $CATEGORIAS->CONEXION = $CONFIG->getConexion();
        if ($resultado = $CATEGORIAS->traerCategorias($tipo)) {
            $categoriasArray = [];
            while ($categoria = $resultado->fetch_assoc()) {
                $categoriasArray[] = array(
                    'categoria' => $categoria,
                    'total_productos' => $CATEGORIAS->contarProductosCat($categoria['id'])
                );
            }

            $respuesta = array(
                'respuesta' => 'exito',
                'Texto' => 'Categorias encontradas',
                'categorias' => $categoriasArray,
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No existen categorias'
            );
        }

        die(json_encode($respuesta));
        break;
    case 'crear':
        $nombre  = isset($_POST['nombre']) && !empty($_POST['nombre']) ? $_POST['nombre'] : false;
        $CATEGORIAS = new Categorias();
        $CATEGORIAS->CONEXION = $CONFIG->getConexion();
        if ($USERSYSTEM) {
            $resultado = $CATEGORIAS->buscarCategoria($nombre);
            if (!$resultado) {
                $res_categoria = $CATEGORIAS->crearCategoria($nombre);
                if ($res_categoria) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Categoria creada de manera exitosa'
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Por el momento no es posible registrar una nueva categoria'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'La categoria que intenta ingresar ya existe'
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
    case 'editar':
        $nombre  = isset($_POST['nombre']) && !empty($_POST['nombre']) ? $_POST['nombre'] : false;
        $id  = isset($_POST['id']) && !empty($_POST['id']) ? (int) $_POST['id'] : false;
        $estado  = isset($_POST['estado']) && !empty($_POST['estado']) ? $_POST['estado'] : false;

        $CATEGORIAS = new Categorias();
        $CATEGORIAS->CONEXION = $CONFIG->getConexion();
        if ($USERSYSTEM) {
            if (!$nombre || !$estado || !$id) {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No llegaron los datos de manera correcta'
                );
            } else {
                // die(json_encode($_POST));
                $res_categoria = $CATEGORIAS->actualizarCategoria($id, $nombre, $estado);
                if ($res_categoria) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Categoria creada de manera exitosa'
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'No fue posible realizar Cambios', $res_categoria
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
    case 'eliminar':
        $id  = isset($_POST['id']) && !empty($_POST['id']) ? (int) $_POST['id'] : false;
        $CATEGORIAS = new Categorias();
        $CATEGORIAS->CONEXION = $CONFIG->getConexion();
        if ($USERSYSTEM) {
            if ($USERSYSTEM['cargo'] != "administrador") {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No tienes permisos para eliminar una categoria'
                );
            } elseif (!$id) {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No llegaron los datos de manera correcta'
                );
            } else {
                if ($CATEGORIAS->contarProductosCat($id) == 0) {

                    if ($CATEGORIAS->eliminarCategoria($id)) {
                        $respuesta = array(
                            'respuesta' => 'exito',
                            'Texto' => 'La categoria fue eliminada'
                        );
                    } else {
                        $respuesta = array(
                            'respuesta' => 'error',
                            'Texto' => 'No fue posible eliminar el registro'
                        );
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'La categoria contiene productos registrados'
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

    default:
        # code...
        break;
}
