<?php

namespace App\Models;

class Categorias
{
    var $CORREO;
    var $CONEXION;
    function traerCategorias($sistema = true)
    {
        $sistema = ($sistema) ? "WHERE estado = 'activo'" : "";
        $sql = "SELECT * FROM categorias $sistema ORDER BY categoria ASC";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta : false);
    }
    function buscarCategoria($nombre)
    {
        $sql = "SELECT * FROM categorias WHERE categoria = '$nombre'";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta : false);
    }
    function crearCategoria($nombre)
    {
        $sql = "INSERT INTO categorias(categoria, estado ) VALUES ('$nombre','activo')";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? $this->CONEXION->insert_id : false);
    }
    function actualizarCategoria($id, $nombre, $estado)
    {
        $sql = "UPDATE categorias SET categoria='$nombre',estado='$estado' WHERE id=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function eliminarCategoria($id)
    {
        $sql = "DELETE FROM `categorias` WHERE id=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }

    function contarProductosCat($idCategoria)
    {
        $sql = "SELECT COUNT(*) AS total FROM productos WHERE id_categoria = $idCategoria";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? $respuesta->fetch_assoc()['total'] : 0);
    }
}
