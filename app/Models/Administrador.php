<?php

namespace App\Models;

class Administrador
{
    function MESES($dia)
    {
        $MES = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        return $MES[$dia];
    }
    function generarCodigo($longitud)
    {
        $key = "";
        $pattern = "1234FAGS5F67N8N90ABC0DEF0GHIJ0KLMN70OPQR880S56TU1V01WXY1Z";
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern{
                mt_rand(0, $max)};
        }
        return $key;
    }
    function generarPassword($longitud)
    {
        $key = "";
        $pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ#%@.-";
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern{
                mt_rand(0, $max)};
        }
        return $key;
    }
    function optimizar_imagen($origen, $destino, $calidad)
    {

        $info = getimagesize($origen);

        if ($info['mime'] == 'image/jpeg') {
            $imagen = imagecreatefromjpeg($origen);
        } else if ($info['mime'] == 'image/gif') {
            $imagen = imagecreatefromgif($origen);
        } else if ($info['mime'] == 'image/png') {
            $imagen = imagecreatefrompng($origen);
        }

        $enviar = imagejpeg($imagen, $destino, $calidad);

        return $enviar;
    }
    function validarImagen($imagen)
    {
        // echo json_encode($imagen);
        $tipo = $imagen["type"];
        $admitidos = ["image/jpg", "image/jpeg", "image/gif", "image/bmp", "image/png"];
        if (array_search($tipo, $admitidos)) {
            // $tamano = getimagesize($imagen['tmp_name']);
            // echo json_encode($tamano);
            if ($imagen['size'] > 5000000) {
                die(json_encode(array(
                    'respuesta' => 'error',
                    'Texto' => 'tamaño exedido ' . $imagen['size']
                )));
            }
        } else {
            die(json_encode(array(
                'respuesta' => 'error',
                'Texto' => 'tamaño exedido ', $imagen
            )));
        }
    }
    function eliminar_simbolos($string)
    {
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
        $string = str_replace(
            array(
                "\\", "¨", "º", "-", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "<code>", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":",
                ".", " "
            ),
            ' ',
            $string
        );
        return $string;
    }
    function limpiarEnlaces($cadena)
    {
        $cadena = $this->limpiarEspacios($cadena);
        return str_replace(" ", "-", $cadena);
    }
    function limpiarEspacios($cadena)
    {
        $limpia    = "";
        $parts    = [];
        // divido la cadena con todos los espacios q haya
        $parts = explode(" ", $cadena);
        foreach ($parts as $subcadena) {
            // de cada subcadena elimino sus espacios a los lados
            // $subcadena = trim($subcadena);
            // luego lo vuelvo a unir con un espacio para formar la nueva cadena limpia
            // omitir los que sean unicamente espacios en blanco
            if ($subcadena != "") {
                $limpia .= $subcadena . " ";
            }
        }
        $limpia = trim($limpia);
        return $limpia;
    }
    function rellenarCero($valor, $nCeros = 5)
    {
        $cero = '';
        for ($i = strlen($valor); $i < $nCeros; $i++) {
            $cero .= '0';
        }
        return ($cero . $valor);
    }
}
