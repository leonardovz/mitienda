<?php

namespace App\Models;

use App\Config\Config;

class Usuarios
{
    var $CORREO;
    var $CONEXION;
    /**
     * CONFIG USUARIOS
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
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false);
    }

    function traerUsuarios($sistema = true)
    {
        $filtro = '';

        if ($this->nombre) {
            $filtro .= (($filtro == '') ? " WHERE " : " AND ") . "nombre like '%" . $this->nombre . "%'";
        }
        if ($this->id) {
            $filtro .= (($filtro == '') ? " WHERE " : " AND ") . 'id =' . $this->id;
        }
        if ($this->apellidos) {
            $filtro .= (($filtro == '') ? " WHERE " : " AND ") . "apellidos like '%" . $this->apellidos . "%'";
        }

        if ($this->correo) {
            $filtro .= (($filtro == '') ? " WHERE " : " AND ") . "correo like '%" . $this->correo . "%'";
        }
        if ($this->cargo) {
            $filtro .= (($filtro == '') ? " WHERE " : " AND ") . "cargo like '%" . $this->cargo . "%'";
        }
        if ($this->estado) {
            $filtro .= (($filtro == '') ? " WHERE " : " AND ") . "estado like '%" . $this->estado . "%'";
        }

        $sql = "SELECT id, nombre, apellidos, correo, perfil, foto, ultimo_login, fecha, estado, cargo FROM usuarios  $filtro ORDER BY apellidos ASC";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta : false);
    }
    function buscarUsuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false);
    }
    function crearUsuario($nombre)
    {
        $nombre =       $this->nombre;
        $apellidos =    $this->apellidos;
        $correo =       $this->correo;
        $password =     $this->password;
        $estado =       $this->estado;
        $cargo =        $this->cargo;

        $sql = "INSERT INTO usuarios(nombre, apellidos, correo, password,estado, cargo) VALUES ('$nombre','$apellidos','$correo','$password','$estado','$cargo')";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? $this->CONEXION->insert_id : false);
    }
    function actualizarUsuario()
    {
        $id        = $this->id;
        $nombre    = $this->nombre;
        $apellidos = $this->apellidos;
        $correo    = $this->correo;
        $cargo    = $this->cargo;
        $sql = "UPDATE usuarios SET nombre ='$nombre' ,apellidos ='$apellidos',correo ='$correo',cargo ='$cargo' WHERE id=$id";

        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function actualizar_estado()
    {
        $id    = $this->id;
        $estado    = $this->estado;

        $sql = "UPDATE usuarios SET estado='$estado' WHERE id=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function actualizar_password()
    {
        $id = $this->id;
        $password = $this->password;

        $sql = "UPDATE usuarios SET password='$password' WHERE id=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? true : false);
    }
    function contarUsuarios()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta) ? $respuesta->fetch_assoc()['total'] : false);
    }
}
