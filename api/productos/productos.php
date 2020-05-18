<?php

use App\Models\{Productos, Administrador};

$opcion = isset($_POST['opcion']) ? htmlspecialchars($_POST['opcion']) : false;

switch ($opcion) {
    case 'mostrar':
        $pagina  = (isset($_POST['pagina']) && !empty($_POST['pagina'])) ?  (int) $_POST['pagina'] : 0;
        $busqueda  = (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) ?  $_POST['busqueda'] : false;
        $categoria  = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ?  (int) $_POST['categoria'] : false;
        $tipo  = (isset($_POST['tipo']) && !empty($_POST['tipo'])) ?  $_POST['tipo'] : false;
        // die(json_encode($_POST));
        $PRODUCTOS = new Productos();
        $PRODUCTOS->pagina = $pagina; //Pagina actual, comienza en 1 la funcion hace el calculo de paginacion
        $PRODUCTOS->buscar = $busqueda;
        $PRODUCTOS->id_categoria = $categoria; //En caso de requerir busqueda por categoria
        $PRODUCTOS->estado = $tipo; //En caso de requerir busqueda por categoria
        // $PRODUCTOS->limite = 2;

        if ($USERSYSTEM) {
            if ($resultado = $PRODUCTOS->traerProductos()) {
                $productosArray = [];
                while ($producto = $resultado->fetch_assoc()) {
                    $producto['url_img'] = $RUTA . 'galeria/productos/' . $producto['imagen'];
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
    case 'crear':
        // die(json_encode(array($_POST, $_FILES)));

        $nombre =          isset($_POST['nombre'])              && !empty($_POST['nombre'])          ? htmlspecialchars($_POST['nombre']) : false;
        $descripcion =     isset($_POST['descripcion'])         && !empty($_POST['descripcion'])     ? htmlspecialchars($_POST['descripcion']) : false;
        $codigo =          isset($_POST['codigo'])              && !empty($_POST['codigo'])          ? htmlspecialchars($_POST['codigo']) : false;
        $stock =           isset($_POST['stock'])               && !empty($_POST['stock'])           ? (int) $_POST['stock'] : false;
        $minStok =         isset($_POST['minStok'])             && !empty($_POST['minStok'])         ? (int) $_POST['minStok'] : false;
        $precio_compra =   isset($_POST['precio_compra'])       && !empty($_POST['precio_compra'])   ? (int) $_POST['precio_compra'] : false;
        $precio_venta =    isset($_POST['precio_venta'])        && !empty($_POST['precio_venta'])    ? (int) $_POST['precio_venta'] : false;
        $categoria =    isset($_POST['selCategoria'])        && !empty($_POST['selCategoria'])    ? (int) $_POST['selCategoria'] : false;
        $estado = isset($_POST['productoPublico'])     && !empty($_POST['productoPublico']) && $_POST['productoPublico'] == 'true' ? 'activo' : 'inactivo';

        $PRODUCTOS = new Productos();
        $ADMIN = new Administrador();
        if ($USERSYSTEM) {
            if ($nombre && $descripcion && $stock && $minStok && $precio_compra && $precio_venta && $categoria) {

                $PRODUCTOS->id_categoria = $categoria;
                $PRODUCTOS->codigo = ($codigo) ? $codigo : $categoria . $PRODUCTOS->codigoUnico();
                $PRODUCTOS->nombre = $nombre;
                $PRODUCTOS->estado = $estado;
                $PRODUCTOS->descripcion = $descripcion;
                $PRODUCTOS->stock = $stock;
                $PRODUCTOS->min_stock = $minStok;
                $PRODUCTOS->precio_compra = $precio_compra;
                $PRODUCTOS->precio_venta = $precio_venta;


                $nombre_imagen = strtolower($ADMIN->limpiarEnlaces($ADMIN->eliminar_simbolos($nombre)));

                $IMAGENPRODUCTO = $_FILES['avatar'];
                $IMAGENTYPE = explode(".", $IMAGENPRODUCTO['name']);
                $IMAGENTYPE = end($IMAGENTYPE);


                $ADMIN->validarImagen($IMAGENPRODUCTO);

                $PRODUCTOS->imagen  = $nombre_imagen = $nombre_imagen . '_' . time() . "_" . $categoria . '.' . $IMAGENTYPE;
                $directorio = '../public/galeria/productos/';
                echo __DIR__;

                if ($PRODUCTOS->crearProducto()) {
                    $source = $IMAGENPRODUCTO["tmp_name"];              //Obtenemos el nombre temporal del archivo
                    // die(json_encode(array($_POST, $_FILES)));
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777) or die(json_encode(array('respuesta' => 'error', 'Texto' => "No se puede crear el directorio de extracción")));
                    }

                    $dir = opendir($directorio); //Abrimos el directorio de destino

                    $movimiento = $ADMIN->optimizar_imagen($source, $directorio . $nombre_imagen, 50); //Se encarga de comprimir la imagen y guardarla

                    closedir($dir); //Cerramos el directorio de destino

                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Llegaron los datos necesarios', $PRODUCTOS->imagen, //,
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'No fue posible realizar su registro, intente nuevamente', //,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'Es necesario que completes todos los campos',
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permitido realizar esta acción',
            );
        }
        die(json_encode($respuesta));
        break;
    case 'editar':

        $idProducto =      isset($_POST['idProducto'])    && !empty($_POST['idProducto'])      ? (int) $_POST['idProducto'] : false;
        $nombre =          isset($_POST['nombre'])        && !empty($_POST['nombre'])          ? htmlspecialchars($_POST['nombre']) : false;
        $descripcion =     isset($_POST['descripcion'])   && !empty($_POST['descripcion'])     ? htmlspecialchars($_POST['descripcion']) : false;
        $codigo =          isset($_POST['codigo'])        && !empty($_POST['codigo'])          ? htmlspecialchars($_POST['codigo']) : false;
        $stock =           isset($_POST['stock'])         && !empty($_POST['stock'])           ? (int) $_POST['stock'] : false;
        $minStok =         isset($_POST['minStok'])       && !empty($_POST['minStok'])         ? (int) $_POST['minStok'] : false;
        $precio_compra =   isset($_POST['precio_compra']) && !empty($_POST['precio_compra'])   ? (int) $_POST['precio_compra'] : false;
        $precio_venta =    isset($_POST['precio_venta'])  && !empty($_POST['precio_venta'])    ? (int) $_POST['precio_venta'] : false;
        $categoria =    isset($_POST['selCategoria'])     && !empty($_POST['selCategoria'])    ? (int) $_POST['selCategoria'] : false;
        $estado = isset($_POST['productoPublico'])        && !empty($_POST['productoPublico']) && $_POST['productoPublico'] == 'true' ? 'activo' : 'inactivo';

        $PRODUCTOS = new Productos();
        $ADMIN = new Administrador();
        if ($USERSYSTEM) {

            if ($nombre && $descripcion && $stock && $minStok && $precio_compra && $precio_venta && $categoria) {

                $PRODUCTOS->id = $idProducto;
                $PRODUCTOS->id_categoria = $categoria;
                $PRODUCTOS->codigo = ($codigo) ? $codigo : $categoria . $PRODUCTOS->codigoUnico();
                $PRODUCTOS->nombre = $nombre;
                $PRODUCTOS->estado = $estado;
                $PRODUCTOS->descripcion = $descripcion;
                $PRODUCTOS->stock = $stock;
                $PRODUCTOS->min_stock = $minStok;
                $PRODUCTOS->precio_compra = $precio_compra;
                $PRODUCTOS->precio_venta = $precio_venta;


                $nombre_imagen = strtolower($ADMIN->limpiarEnlaces($ADMIN->eliminar_simbolos($nombre)));

                $IMAGENPRODUCTO = isset($_FILES['avatar']) & !empty($_FILES['avatar']) ? $_FILES['avatar'] : false;

                if ($IMAGENPRODUCTO) {

                    if (($IMAGENPRODUCTO['error']) == 0) {
                        $IMAGENTYPE = explode(".", $IMAGENPRODUCTO['name']);
                        $IMAGENTYPE = end($IMAGENTYPE);
                        $ADMIN->validarImagen($IMAGENPRODUCTO);
                        $PRODUCTOS->imagen  = $nombre_imagen = $nombre_imagen . '_' . time() . "_" . $categoria . '.' . $IMAGENTYPE;
                        $directorio = '../public/galeria/productos/';
                    } else {
                        die(json_encode(array('respuesta' => 'error', 'Texto' => "La imagen no se cargo de manera correcta", $_FILES)));
                    }
                }

                $producto = $PRODUCTOS->buscarProducto($idProducto);
                if ($PRODUCTOS->actualizarProducto()) {
                    if ($IMAGENPRODUCTO) {
                        $source = $IMAGENPRODUCTO["tmp_name"];              //Obtenemos el nombre temporal del archivo
                        if (!file_exists($directorio)) {
                            mkdir($directorio, 0777) or die(json_encode(array('respuesta' => 'error', 'Texto' => "No se puede crear el directorio de extracción")));
                        }
                        $dir = opendir($directorio); //Abrimos el directorio de destino
                        $movimiento = $ADMIN->optimizar_imagen($source, $directorio . $nombre_imagen, 50); //Se encarga de comprimir la imagen y guardarla
                        if ($producto) {
                            if (is_file($directorio . $producto['imagen'])) {
                                unlink($directorio . $producto['imagen']);
                            }
                        }
                        closedir($dir); //Cerramos el directorio de destino
                    }


                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Datos actualizados de manera correcta', $PRODUCTOS->imagen, //,
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'No fue posible realizar su registro, es posible que no haya modificado los datos del producto', $_FILES //,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'Es necesario que completes todos los campos',
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permitido realizar esta acción',
            );
        }
        die(json_encode($respuesta));
        break;

    default:
        # code...
        break;
}
