<?php

namespace App\Models;

use App\Config\Config;
use App\Models\Administrador;


class Productos
{
    var $CONEXION;
    var $id;
    var $id_categoria;
    var $codigo;
    var $nombre;
    var $estado;

    var $descripcion;
    var $imagen;
    var $stock;
    var $min_stock;
    var $precio_compra;
    var $precio_venta;
    /**
     * TRAER UN ELEMENTO
     */
    var $buscar;
    var $pagina;
    var $limite;

    /**
     * filtro Precio
     */
    var $costo = false;
    var $costo_min = false;
    var $costo_max = false;
    /** */
    private $total_Productos;
    function __construct()
    {
        $config = new Config();
        $this->CONEXION = $config->getConexion();
        $this->id = false;
        $this->id_categoria = false;
        $this->codigo = false;
        $this->nombre = false;
        $this->imagen = false;

        /**
         * TRAER UN ELEMENTO
         */
        $this->estado = false;
        $this->buscar = false;
        $this->pagina = 0;
        $this->limite = 12;
    }

    function traerProductos()
    {
        $registro = ($this->pagina > 0 ? $this->pagina - 1 : 0) * $this->limite; //Calcula la posicion de la paginacion

        $filtros = '';
        if ($this->buscar) {
            $filtros .=

                " AND (C.categoria LIKE '" . $this->buscar . "%' " .
                "OR P.nombre LIKE '%" . $this->buscar . "%' " .
                "OR P.descripcion LIKE '%" . $this->buscar . "%' " .
                "OR P.codigo LIKE '%" . $this->buscar . "%' " .
                ') ';
        }
        if ($this->id) {
            $filtros .= " AND (P.id = " . $this->id . ') ';
        }
        if ($this->id_categoria) {
            $filtros .= " AND C.id = " . $this->id_categoria;
        }
        if ($this->estado) {
            $filtros .= " AND P.estado = '" . $this->estado . "' ";
        }
        if ($this->costo) {
            $min = $this->costo_min;
            $max = $this->costo_max;
            $filtros .= "AND (P.precio_venta >= $min AND P.precio_venta <= $max ) ";
        }

        $sql = "SELECT P.*, C.categoria FROM productos AS P, categorias AS C WHERE P.id_categoria = C.id $filtros ORDER BY P.nombre ASC LIMIT " . $registro . ',' . $this->limite . ';';
        $sql_contar = "SELECT COUNT(*) as total FROM productos AS P, categorias AS C WHERE P.id_categoria = C.id $filtros ";

        $res_contar = $this->CONEXION->query($sql_contar);
        $this->total_Productos = ($res_contar && $res_contar->num_rows) ? $res_contar->fetch_assoc()['total'] : 0;

        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta : false);
    }
    function getCantidadProductos()
    {
        return $this->total_Productos;
    }
    function crearProducto()
    {
        $sql = 'INSERT INTO productos(id_categoria, nombre, codigo, descripcion, imagen, stock,min_stock, precio_compra, precio_venta, estado) VALUES (' . $this->id_categoria . ',"' . $this->nombre . '","' . $this->codigo . '","' . $this->descripcion . '","' . $this->imagen . '",' . $this->stock . ',' . $this->min_stock . ',' . $this->precio_compra . ',' . $this->precio_venta . ',"' . $this->estado . '")';
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $this->CONEXION->insert_id) ? $this->CONEXION->insert_id : false;
        return $resultado;
    }
    function buscarProducto($id = false, $codigo = false)
    {
        $ID =  ($id) ? ' AND P.id = ' . $id : "";
        $filtros = '';
        $CODE =  ($codigo) ? ' AND P.codigo = "' . $codigo . '"' : "";
        if ($this->estado) {
            $filtros .= " AND P.estado = '" . $this->estado . "' ";
        }
        $sql = 'SELECT P.*, C.categoria  FROM  productos AS P , categorias as C WHERE P.id_categoria = C.id ' . $ID . $CODE . $filtros . ' ;';
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $resultado;
    }
    function actualizarProducto()
    {
        // 
        $ac_id_categoria  = 'id_categoria =' .  $this->id_categoria;
        $ac_nombre        = 'nombre = "' . $this->nombre . '"';
        $ac_codigo        = 'codigo = "' . $this->codigo . '"';
        $ac_descripcion   = 'descripcion = "' . $this->descripcion . '"';
        $ac_imagen        =  $this->imagen ? ',imagen = "' . $this->imagen . '"' : "";
        $ac_stock         = 'stock = ' . $this->stock;
        $ac_min_stock     = 'min_stock = ' . $this->min_stock;
        $ac_precio_compra = 'precio_compra = "' . $this->precio_compra . '"';
        $ac_precio_venta  = 'precio_venta = "' . $this->precio_venta . '"';
        $ac_estado        = 'estado = "' . $this->estado . '"';
        $sql = 'UPDATE `productos` SET ' . $ac_id_categoria . ',' . $ac_nombre . ',' . $ac_codigo . ',' . $ac_descripcion  . $ac_imagen . ',' . $ac_stock . ',' . $ac_min_stock . ',' . $ac_precio_compra . ',' . $ac_precio_venta . ',' . $ac_estado . 'WHERE id=' . $this->id;
        // return $sql;
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $this->CONEXION->affected_rows) ? $this->CONEXION->affected_rows : false;
        return $resultado;
    }
    function codigoUnico()
    {
        $ADMIN = new Administrador();
        $codigo = $ADMIN->generarCodigo(6);
        if ($this->buscarProducto(false, $codigo)) {
            $codigo = $this->codigoUnico();
        } else {
            return $codigo;
        }
    }
}
