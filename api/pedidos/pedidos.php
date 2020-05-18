<?php

use App\Models\{Ventas, Administrador};

$opcion = isset($_POST['opcion']) ? htmlspecialchars($_POST['opcion']) : false;


switch ($opcion) {
    case 'mostrar':
        $pagina  = (isset($_POST['pagina']) && !empty($_POST['pagina'])) ?  (int) $_POST['pagina'] : 0;
        $busqueda  = (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) ?  $_POST['busqueda'] : false;
        $categoria  = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ?  (int) $_POST['categoria'] : false;
        $tipo  = (isset($_POST['tipo']) && !empty($_POST['tipo'])) ?  $_POST['tipo'] : false;
        //Completar datos para hacer el filtro

        $VENTAS = new Ventas();
        $VENTAS->pagina = $pagina; //Pagina actual, comienza en 1 la funcion hace el calculo de paginacion
        $VENTAS->buscar = $busqueda;
        $VENTAS->id_categoria = $categoria; //En caso de requerir busqueda por categoria
        $VENTAS->estado = $tipo; //En caso de requerir busqueda por categoria
        // $VENTAS->limite = 2;

        if ($USERSYSTEM) {
            if ($resultado = $VENTAS->traer_pedidos()) {
                $productosArray = [];
                while ($producto = $resultado->fetch_assoc()) {
                    $productosArray[] = array(
                        'producto' => $producto,
                        ''
                    );
                }
                $respuesta = array(
                    'respuesta' => 'exito',
                    'Texto' => 'Encontré algo',
                    'productos' => $productosArray,
                    // 'total' => (int) $VENTAS->getCantidadVentas(),
                    'pagina' => $VENTAS->pagina
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No existen categorías',
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
        $iva =         isset($_POST['iva'])         && !empty($_POST['iva'])         ? (int) $_POST['iva'] : 0;
        $metodo_pago = isset($_POST['metodo_pago']) && !empty($_POST['metodo_pago']) ? $_POST['metodo_pago'] : 'efectivo';
        $ticket =      isset($_POST['carrito'])      && !empty($_POST['carrito'])      ? $_POST['carrito'] : false;
        $id_cliente =  isset($_POST['id_cliente'])  && !empty($_POST['id_cliente'])  ? $_POST['id_cliente'] : '';
        $id_vendedor =  isset($_POST['idVendedor'])  && !empty($_POST['idVendedor'])  ? $_POST['idVendedor'] : 0;
        $id_vendedor =  isset($_POST['idVendedor'])  && !empty($_POST['idVendedor'])  ? $_POST['idVendedor'] : 0;
        $envio_control =  isset($_POST['envio_control'])  && !empty($_POST['envio_control'])  ? $_POST['envio_control'] : 'yo';
        $comentario =  isset($_POST['comentario'])  && !empty($_POST['comentario'])  ? $_POST['comentario'] : '';

        $ticket = json_decode($ticket, true);
        $impuesto = 1.16; //SUMA DEL IVA
        $VENTAS = new Ventas();
        $ADMIN = new Administrador();
        // die(json_encode($_POST));

        if ($USERSYSTEM) {
            if ($ticket) {
                $PRODUCTOS = $VENTAS->buscar_productos($ticket);
                if ($PRODUCTOS) {
                    $productos_array = [];
                    $NETO = 0;
                    $TOTAL = 0;
                    while ($producto = $PRODUCTOS->fetch_assoc()) {
                        foreach ($ticket as $i => $valor) {
                            if ($producto['id'] == $valor['id']) {
                                $producto['cantidad'] = '' . $valor['cantidad'];
                            }
                        }
                        $productos_array[] = $producto;
                        $costo = (int) ($producto['costo']);
                        $cantidad = (int) ($producto['cantidad']);
                        $total_producto = ($cantidad * $costo); //Calculo del neto

                        $NETO = $NETO + ($total_producto); //Neto total de la cuenta
                        $TOTAL = $TOTAL + (($iva == 1) ? ($total_producto) * $impuesto : ($total_producto)); //En caso de que tenga IVA
                    }

                    $VENTAS->neto = $NETO;
                    $VENTAS->total = $TOTAL;

                    $VENTAS->id_cliente = $USERSYSTEM['idUsuario'];
                    $VENTAS->id_vendedor = $id_vendedor;
                    $VENTAS->productos = json_encode($productos_array, true);
                    $VENTAS->impuesto = $iva;
                    $VENTAS->metodo_pago = $metodo_pago;

                    $VENTAS->tipo_envio = $envio_control;
                    $VENTAS->comentario_cliente = $comentario;

                    // die(json_encode($_POST));

                    if ($resultado = $VENTAS->guardarVenta()) {
                        $respuesta = array(
                            'respuesta' => 'exito',
                            'Texto' => 'Pedido armado',
                            'pedido' => $resultado
                        );
                    } else {
                        $respuesta = array(
                            'respuesta' => 'error',
                            'Texto' => 'No fue posible registrar la nota en el último paso',
                        );
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Se manipularon datos es necesario rehacer la nota',
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No es posible generar una nota con productos en blanco',
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

        $VENTAS = new Ventas();
        $ADMIN = new Administrador();
        if ($USERSYSTEM) {
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permitido realizar esta acción',
            );
        }
        die(json_encode($respuesta));
        break;

    case 'mis_pedidos':
        $pagina =          isset($_POST['pagina'])        && !empty($_POST['pagina'])          ? (int) ($_POST['pagina']) : 1;
        $busqueda =        isset($_POST['busqueda'])      && !empty($_POST['busqueda'])        ? htmlspecialchars($_POST['busqueda']) : false;
        $estado =          isset($_POST['estado'])        && !empty($_POST['estado'])          ? htmlspecialchars($_POST['estado']) : false;

        //Completar datos para hacer el filtro

        $VENTAS = new Ventas();
        $VENTAS->pagina_ac = $pagina; //Pagina actual, comienza en 1 la funcion hace el calculo de paginacion
        $VENTAS->buscar = $busqueda;

        $VENTAS->estado = $estado; //En caso de requerir busqueda por categoria
        $VENTAS->id_cliente = (int) $USERSYSTEM['idUsuario']; //En caso de requerir busqueda por categoria
        if ($USERSYSTEM) {
            if ($resultado = $VENTAS->traer_pedidos()) {
                $productosArray = [];
                while ($producto = $resultado->fetch_assoc()) {
                    $producto['productos'] = json_decode($producto['productos'], true);
                    $productosArray[] = array(
                        'pedido' => $producto,
                    );
                }
                $respuesta = array(
                    'respuesta' => 'exito',
                    'Texto' => 'Encontré algo',
                    'pedidos' => $productosArray,
                    'total' => (int) $VENTAS->total_ventas(),
                    'pagina' => $VENTAS->pagina_ac
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No se encontraron resultados de tu búsqueda',
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
    case 'pedidos_vendedor':
        $pagina =          isset($_POST['pagina'])        && !empty($_POST['pagina'])          ? (int) ($_POST['pagina']) : 1;
        $busqueda =        isset($_POST['busqueda'])      && !empty($_POST['busqueda'])        ? htmlspecialchars($_POST['busqueda']) : false;
        $estado =          isset($_POST['estado'])        && !empty($_POST['estado'])          ? htmlspecialchars($_POST['estado']) : false;
        $id_cliente =      isset($_POST['id_cliente'])    && !empty($_POST['id_cliente'])      ? htmlspecialchars($_POST['id_cliente']) : false;

        //Completar datos para hacer el filtro

        $VENTAS = new Ventas();
        $VENTAS->pagina_ac = $pagina; //Pagina actual, comienza en 1 la funcion hace el calculo de paginacion
        $VENTAS->buscar = $busqueda;

        $VENTAS->estado      = $estado; //En caso de requerir busqueda por categoria
        $VENTAS->id_cliente  = $id_cliente; //En caso de requerir busqueda por categoria
        $VENTAS->id_vendedor = $USERSYSTEM['cargo'] == 'vendedor' ? (int) $USERSYSTEM['idUsuario'] : false; //En caso de requerir busqueda por categoria

        if ($USERSYSTEM) {
            if ($resultado = $VENTAS->traer_pedidos()) {
                $productosArray = [];
                while ($producto = $resultado->fetch_assoc()) {
                    $producto['productos'] = json_decode($producto['productos'], true);
                    $productosArray[] = array(
                        'pedido' => $producto,
                    );
                }
                $respuesta = array(
                    'respuesta' => 'exito',
                    'Texto' => 'Encontré algo',
                    'pedidos' => $productosArray,
                    'total' => (int) $VENTAS->total_ventas(),
                    'pagina' => $VENTAS->pagina_ac
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No se encontraron resultados de tu búsqueda',
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
    case 'cancelar_pedido':
        $id_pedido =     isset($_POST['id_pedido'])         && !empty($_POST['id_pedido'])          ? (int) ($_POST['id_pedido']) : 1;
        // $estado_pedido = isset($_POST['estado_pedido'])     && !empty($_POST['estado_pedido'])      ? (int) ($_POST['estado_pedido']) : 1;
        $VENTA = new Ventas();
        if ($USERSYSTEM) {
            $result_venta = $VENTA->buscar_venta($id_pedido, $USERSYSTEM['idUsuario'], $USERSYSTEM['cargo']);
            if ($result_venta) {
                if ($result_venta['status'] == 'pendiente' && ($result_venta['id_cliente'] == $USERSYSTEM['idUsuario'])) {
                    $VENTA->actualizar_venta($id_pedido, 'cancelado');
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Tu pedido ha sido cancelado', $result_venta
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Para cancelar el pedido,debes de contactar al vendedor o repartidor', $result_venta
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No tienes permisos de realizar la acción que requieres'
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permisos de realizar la acción que requieres'
            );
        }

        die(json_encode($respuesta));
        break;
    case 'actualizar_pedido':
        $id_pedido =     isset($_POST['id_pedido'])         && !empty($_POST['id_pedido'])          ? (int) ($_POST['id_pedido']) : false;
        $estado_pedido = isset($_POST['estado'])     && !empty($_POST['estado'])      ? htmlspecialchars($_POST['estado']) : false;
        $VENTA = new Ventas();
        if ($USERSYSTEM) {
            $result_venta = $VENTA->buscar_venta($id_pedido, $USERSYSTEM['idUsuario'], $USERSYSTEM['cargo']);
            if ($result_venta) {
                if ($result_venta['status'] != 'cancelado' && ($result_venta['id_vendedor'] == $USERSYSTEM['idUsuario'] || $result_venta['id_repartidor'] == $USERSYSTEM['idUsuario'])) {
                    $VENTA->actualizar_venta($id_pedido, $estado_pedido);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'Texto' => 'Tu pedido ha sido actualizado', $result_venta, $_POST
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'Texto' => 'Solamente un vendedor o repartidor pueden actualizar el estado del pedido', $result_venta, $_POST
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'Texto' => 'No tienes permisos de realizar la acción que requieres'
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'No tienes permisos de realizar la acción que requieres'
            );
        }

        die(json_encode($respuesta));
        break;
    default:
        # code...
        break;
}
