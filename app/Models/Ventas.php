<?php

namespace App\Models;

use App\Config\Config;

class Ventas
{
    private $CONEXION;

    var $id_venta;
    var $codigo;
    var $id_cliente;
    var $id_vendedor;
    var $id_repartidor;
    var $productos;
    var $impuesto;
    var $neto;
    var $total;
    var $metodo_pago;

    /**
     * DATOS VENTA
     */
    var $tipo_envio;
    var $comentario_cliente;
    var $comentario_cliente_vendedor;
    var $valoracion;
    var $estado;
    /**
     * CONTROL DE LA PAGINACIÓN
     */
    var $ventas_totales;
    var $pagina_ac;
    var $limite;
    var $buscar;

    function __construct()
    {
        $CONF = new Config();
        $this->CONEXION = $CONF->getConexion();

        $this->id_venta = 0;
        $this->codigo = '';
        $this->id_cliente = false;
        $this->id_vendedor = false;
        $this->id_repartidor = false;
        $this->productos = '';
        $this->impuesto = '';
        $this->neto = '';
        $this->total = '';
        $this->metodo_pago = '';


        /**
         * DATOS VENTA
         */

        $this->tipo_envio = "yo";
        $this->comentario_cliente = "";
        $this->comentario_cliente_vendedor = "";
        $this->valoracion = 0; // /** 0 a 5 */
        $this->estado = false; // /** 0 a 5 */


        /**
         * CONSULTA Y PAGINACION
         */
        $this->ventas_totales = 1;
        $this->pagina_ac = 1;
        $this->limite = 10;
        $this->buscar = "";
        /** */
    }
    function traer_pedidos()
    {
        /** VENTAS */
        $pagina_ac = ($this->pagina_ac <= 1) ? 0 : $this->pagina_ac - 1;
        $pagina = $this->limite * $pagina_ac;
        $limite = $this->limite;
        $FILTRO = '';
        if ($this->buscar && $this->buscar != '') {
        }
        if ($this->id_cliente !== false) {
            $FILTRO .= " AND (V.id_cliente=$this->id_cliente)";
        }
        if ($this->id_vendedor !== false) {
            $FILTRO .= " AND (V.id_vendedor=$this->id_vendedor)";
        }
        if ($this->id_repartidor !== false) {
            $FILTRO .= " AND (V.id_repartidor=$this->id_repartidor)";
        }
        if ($this->estado) {
            $FILTRO .= " AND (V.status='$this->estado')";
        }
        /**CONTADOR */
        $sql_total = "SELECT COUNT(*) as total FROM ventas AS V,usuarios AS U WHERE U.id = V.id_cliente $FILTRO ";
        $respuesta_total =  $this->CONEXION->query($sql_total);
        $this->ventas_totales  = ($respuesta_total && $respuesta_total->num_rows) ? $respuesta_total->fetch_assoc()['total'] : 1;
        /**CONTADOR */

        $sql = "SELECT V.*, U.nombre, U.apellidos FROM ventas AS V,usuarios AS U WHERE U.id = V.id_cliente $FILTRO LIMIT $pagina,$limite";
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $resultado->num_rows) ? $resultado : false;


        return $resultado;
    }
    function total_ventas()
    {
        return $this->ventas_totales;
    }
    function buscar_productos($ticket)
    {
        $id_str = "";
        foreach ($ticket as $i => $valor) {
            $id_str .= (($i == 0 ? " AND (" : " OR") . " P.id =" . $valor['id']);
        }
        $sql = "SELECT P.id, P.nombre, P.codigo, P.imagen,P.precio_venta AS costo, C.categoria FROM productos AS P, categorias AS C WHERE P.id_categoria = C.id $id_str)";
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $resultado->num_rows) ? $resultado : false;
        return $resultado;
    }
    function guardarVenta($estado = 'pendiente')
    {
        $codigo = $this->codigo;
        $id_cliente = $this->id_cliente;
        $id_vendedor = $this->id_vendedor;
        $productos = $this->productos;
        $impuesto = $this->impuesto;
        $neto = $this->neto;
        $total = $this->total;
        $metodo_pago = $this->metodo_pago;

        $envio =      $this->tipo_envio;
        $comentario = $this->comentario_cliente;

        $sql = "INSERT INTO ventas(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago,tipo_envio,comentario_cliente, status) VALUES ('$codigo','$id_cliente','$id_vendedor','$productos','$impuesto','$neto','$total','$metodo_pago','$envio','$comentario','$estado')";
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $this->CONEXION->insert_id) ? $this->CONEXION->insert_id : false;
        $this->actualizarCodigoVenta($resultado);

        return $resultado;
    }
    function actualizarCodigoVenta($id_venta, $codigo = false)
    {
        $codigo = (!$codigo) ? time()  . $id_venta : $codigo;
        $sql = "UPDATE ventas SET codigo ='$codigo' WHERE id=$id_venta";
        $this->CONEXION->query($sql);
    }
    function buscar_venta($id_venta, $idUsuario, $rol = false)
    {
        $USER = "";
        if ($idUsuario && !$rol) {
            $USER = "AND ((id_cliente = $idUsuario OR  id_vendedor = $idUsuario OR  id_repartidor = $idUsuario)OR(id_vendedor = 0 OR  id_repartidor = 0))";
        }
        $sql = "SELECT V.*, U.nombre, U.apellidos FROM ventas AS V,usuarios AS U WHERE U.id = V.id_cliente  AND V.id = $id_venta $USER";
        $resultado = $this->CONEXION->query($sql);
        $resultado = ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $resultado;
    }

    function actualizar_venta($id, $estado)
    {
        $actualizar = "";

        if ($this->id_repartidor) {
            $actualizar .= ",id_repartidor =  " . ($estado != 'cancelado' ? $this->id_repartidor : 0);
        }
        $sql = "UPDATE ventas SET status ='$estado' $actualizar WHERE id=$id ";
        $this->CONEXION->query($sql);
    }
}
