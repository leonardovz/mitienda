<?php

use App\Models\{Productos};

$opcion = isset($_POST['opcion']) ? htmlspecialchars($_POST['opcion']) : false;


switch ($opcion) {
    case 'comprobar_productos_carrito':
        $PR = new Productos();
        $carrito  = (isset($_POST['carrito']) && !empty($_POST['carrito'])) ?  json_decode($_POST['carrito'], true) : false;

        if ($carrito) {
            $carrito_array = [];
            foreach ($carrito as $i => $producto) {
                $pr_e = $PR->buscarProducto($producto['id']);
                $producto['existe'] = ($pr_e) ? true : false; //SAi el producto aún existe en la DB
                if ($pr_e) {
                    $producto['existencia'] = ((int) $pr_e['stock'] >= (int) $producto['cantidad'] ? true : false); //Si la cantidad necesaria esta en stok
                    $producto['total'] = (int) $pr_e['stock']; //total de stock
                    $producto['comprar'] = ((int) $pr_e['stock'] > 0 ? true : false); //true || fals; //puede adquirir alguna cantidad de producto
                }
                // $carrito_array['cantidad'];
                $producto['costo'] = ($pr_e) ? (int) $pr_e['precio_venta'] : (int) $producto['costo']; //Costo rectificado
                $producto['id'];
                $producto['img'];
                $producto['name'] = ($pr_e) ?  $pr_e['nombre'] : $producto['name']; //nombre rectificado

                $carrito_array[] = $producto;
            }
            $respuesta = array(
                'respuesta' => 'exito',
                'Texto' => 'Encontré algo',
                'carrito' => $carrito_array,
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'Texto' => 'Tu carrito de compras tiene un error',
            );
        }
        die(json_encode($respuesta));
        break;
}
