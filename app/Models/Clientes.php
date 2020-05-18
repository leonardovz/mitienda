<?php

namespace App\Models;

use App\Config\Config;

class Clientes
{
    var $CORREO;
    var $CONEXION;
    /**
     * CONFIG CLIENTES
     */
    var $id = false;
    var $nombre = false;
    var $apellidos = false;
    var $correo = false;
    var $password = false;
    var $perfil = false;
    var $foto = false;
    var $ultimo_login = false;
    var $fecha = false;
    var $estado = false;
    var $cargo = false;

    function __construct()
    {
        $CONF = new Config();
        $this->CONEXION = $CONF->getConexion();
    }
    function encontrarCorreo($correo)
    {
        $sql = "SELECT * FROM clientes WHERE correo = '$correo'";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false);
    }
    function mostrar_cliente($id)
    {
        $sql = "SELECT * FROM clientes WHERE id = $id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false);
    }
    function traerClientes($sistema = true)
    {
        $filtro = '';


        $sql = "SELECT id, nombre, apellidos, correo, perfil, foto, ultimo_login, fecha, estado, cargo FROM clientes  $filtro ORDER BY apellidos ASC";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta : false);
    }

    function crearCliente($nombre)
    {
        $nombre =       $this->nombre;
        $apellidos =    $this->apellidos;
        $correo =       $this->correo;
        $password =     $this->password;
        $estado =       $this->estado;
        $cargo =        $this->cargo;

        $sql = "INSERT INTO clientes(nombre, apellidos, correo, password,estado, cargo) VALUES ('$nombre','$apellidos','$correo','$password','$estado','$cargo')";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? $this->CONEXION->insert_id : false);
    }
    function actualizarCliente()
    {
        $id        = $this->id;
        $nombre    = $this->nombre;
        $apellidos = $this->apellidos;
        $correo    = $this->correo;
        $cargo    = $this->cargo;
        $sql = "UPDATE clientes SET nombre ='$nombre' ,apellidos ='$apellidos',correo ='$correo',cargo ='$cargo' WHERE id=$id";

        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function actualizar_estado()
    {
        $id    = $this->id;
        $estado    = $this->estado;

        $sql = "UPDATE clientes SET estado='$estado' WHERE id=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function actualizar_password()
    {
        $id = $this->id;
        $password = $this->password;

        $sql = "UPDATE clientes SET password='$password' WHERE id=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function contarClientes()
    {
        $sql = "SELECT COUNT(*) AS total FROM clientes";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? $respuesta->fetch_assoc()['total'] : false);
    }
}
