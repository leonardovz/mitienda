<?php

use App\Config\Config;
use App\Models\{Administrador, Productos};

$CONFIG = new Config();
$ADMIN = new Administrador();
$opcion = isset($_POST['opcion']) ? htmlspecialchars($_POST['opcion']) : false;

switch ($opcion) {
    case 'mostrar':
        $pagina  = (isset($_POST['pagina']) && !empty($_POST['pagina'])) ?  (int) $_POST['pagina'] : 0;
        $busqueda  = (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) ?  $_POST['busqueda'] : false;
        $categoria  = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ?  (int) $_POST['categoria'] : false;
        $limite  = (isset($_POST['limite']) && !empty($_POST['limite'])) ?  (int) $_POST['limite'] : 12;
        $filtro_costo  = (isset($_POST['filtro_costo']) && !empty($_POST['filtro_costo'])) ?  explode("-", $_POST['filtro_costo']) : false;

        $costo_min = ($filtro_costo ? (int) $ADMIN->eliminar_simbolos($filtro_costo[0]) : false);
        $costo_max = ($filtro_costo ? (int) $ADMIN->eliminar_simbolos($filtro_costo[1]) : false);

        $PRODUCTOS = new Productos();
        $PRODUCTOS->pagina = $pagina; //Pagina actual, comienza en 1 la funcion hace el calculo de paginacion
        $PRODUCTOS->buscar = $busqueda;
        $PRODUCTOS->id_categoria = $categoria; //En caso de requerir busqueda por categoria
        $PRODUCTOS->estado = 'activo'; //En caso de requerir busqueda por categoria
        $PRODUCTOS->limite = $limite;

        if ($filtro_costo && $costo_min && $costo_max) {
            $PRODUCTOS->costo = true;
            $PRODUCTOS->costo_min = $costo_min;
            $PRODUCTOS->costo_max = $costo_max;
        }
        if ($filtro_costo && $costo_max < $costo_min) {
            $respuesta = [
                'respuesta' => 'error',
                'Texto' => 'Para hacer un filtro el costo minimo debe de ser siempre mayor al costo maximo'
            ];
        } else if ($resultado = $PRODUCTOS->traerProductos()) {
            $productosArray = [];
            while ($producto = $resultado->fetch_assoc()) {
                $producto['url_img'] = $RUTA . 'galeria/productos/' . $producto['imagen'];
                $producto['url'] = $RUTA . 'productos/' . $producto['id'] . '/' . $ADMIN->limpiarEnlaces($ADMIN->eliminar_simbolos($producto['nombre']));
                $productosArray[] = array(
                    'producto' => $producto,
                );
            }
            $respuesta = array(
                'respuesta' => 'exito',
                'Texto' => 'Encontré algo',
                'productos' => $productosArray,
                'total' => (int) $PRODUCTOS->getCantidadProductos(),
                'pagina' => $PRODUCTOS->pagina
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No existen categorias',
            );
        }
        $respuesta['post'] = $_POST;
        die(json_encode($respuesta));
        break;
    default:
        # code...
        break;
}
