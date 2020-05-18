<?php

/**
 * MODELS
 */

include_once('Models/Templates.php'); //HEADER - NAVBAR ||  FOOTER -- SCRIPTS

include_once('Models/Productos.php');
include_once('Models/Administrador.php');
include_once('Models/Usuarios.php');
include_once('Models/Clientes.php');
include_once('Models/Categorias.php');
include_once('Models/Ventas.php');


/**
 * CONFIGURACION
 */

include_once('Config/config.php');


/**
 * APARTADO DE AGREGADO DE LIBRERIAS
 * PHPMailer
 * other
 */
include_once('librerias/PHPMailer/src/PHPMailer.php');
include_once('librerias/PHPMailer/src/Exception.php');
include_once('librerias/PHPMailer/src/SMTP.php');
include_once('librerias/FPDF/fpdf.php');


/**
 * EMAIL
 */
include_once('Email/Email.php');
