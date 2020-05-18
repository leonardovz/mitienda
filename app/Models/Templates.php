<?php

namespace App\Models;

use App\Config\{Config};

class Templates
{

    public $TITULO;
    public $DESCRIPCION;
    public $KEYWORDS;
    public $RUTA;
    public $SISTEMNAME;
    public $IMG_SISTEMA;
    public $IMG_LOGOS;

    public $DIRECCION;

    /**
     * LIBRERIAS JS/CSS
     * En caso de agregar librerias al proyecto validarlas aquí
     */

    var $bootstrap = false;
    var $asbab = true;
    var $sweetAlert = true;
    var $owlCarousel = true;
    var $adminLTE = false;
    var $cropper = false;
    var $CERRAR_SESSION =  false;
    var $recaptcha =  false;


    /*****
     * END LIBRERIAS JS/CSS
     *****/

    /**
     * COMPLEMENTOS
     */
    /**
     * END COMPLEMENTOS
     */

    function __construct()
    {
        $CONFIG = new Config();
        $this->RUTA = $CONFIG->RUTA();
        $this->SISTEMNAME = "Mi tienda";
        $this->TITULO = "Venta de productos";
        $this->DESCRIPCION = "";
        $this->DIRECCION = "San Francisco de Asís, Jalisco. CP. 47755, Atotonilco el alto, Jalisco";

        $this->KEYWORDS = "";
        $this->IMG_SISTEMA = $this->RUTA . 'galeria/img/logo.png';
        $this->IMG_LOGOS = $this->RUTA . 'galeria/img/absolute.png';
    }

    function header()
    {
        $headerBody =
            '<!DOCTYPE html>' .
            '<html lang="es">' .

            '<head>' .
            '<meta charset="UTF-8">' .
            '<meta http-equiv="X-UA-Compatible" content="IE=edge">' .
            '<title>' . $this->TITULO . ' </title>' .
            '<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">' .
            '<meta http-equiv="Cache-control" content="no-cache">' .
            '<meta http-equiv="Pragma" content="no-cache">' .
            '<meta http-equiv="Expires" Content="0">' .
            '<meta name="keywords" content="' . $this->KEYWORDS . '">' .
            '<meta name="description" content="' . $this->DESCRIPCION . '">' .
            '<meta name="robots" content="all">' .
            '<meta name="author" content="WEBMASTER - Leonardo Vázquez Angulo">' .
            '<!-- Open Graph protocol -->' .
            '<meta property="og:title" content="' . $this->TITULO . '" />' .
            '<meta property="og:site_name" content="' . $this->TITULO . '" />' .
            '<meta property="og:type" content="website" />' .
            '<meta property="og:url" content="' . $this->RUTA . '" />' .
            '<meta property="og:image" content="' . $this->IMG_LOGOS . '" />' .
            '<meta property="og:image:type" content="image/png" />' .
            '<meta property="og:image:width" content="200" />' .
            '<meta property="og:image:height" content="200" />' .
            '<meta property="og:description" content="' . $this->KEYWORDS . '" />' .
            '<meta name="twitter:title" content="' . $this->TITULO . '" />' .
            '<meta name="twitter:image" content="' . $this->IMG_LOGOS . '" />' .
            '<meta name="twitter:url" content="' . $this->RUTA . '" />' .
            '<meta name="twitter:card" content="" />' .
            '<link rel="icon" href="' . $this->IMG_SISTEMA . '" type="image/x-icon">';

        /**
         * LIBRERIAS
         */
        if ($this->bootstrap) {
            $headerBody .=
                '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">'
                . '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/bootstrap.min.css">'
                . '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/mdb.min.css">'
                // . '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/style.css">'
                . '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/jquery.min.js"></script>';
            $headerBody .=
                '<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">' .
                '<link rel="stylesheet" href="' . $this->RUTA . 'library/AdminLTE/dist/css/adminlte.min.css">' .
                '<script type="text/javascript" src="' . $this->RUTA . 'library/AdminLTE/dist/js/adminlte.js"></script>';
        }
        if ($this->asbab) {
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/bootstrap.min.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/core.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/shortcode/shortcodes.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/style.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/responsive.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/custom.css">';
        }
        if ($this->sweetAlert) {
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/sweetalert2/sweetalert2.min.css">';
            $headerBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/sweetalert2/sweetalert2.min.js"></script>';
        }
        if ($this->owlCarousel) {
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/owl.carousel.min.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/asbab/css/owl.theme.default.min.css">';
        }
        if ($this->cropper) {
            $headerBody .=
                '<link rel="stylesheet" href="' . $this->RUTA . 'library/cropper/cropper.css">' .
                '<script type="text/javascript" src="' . $this->RUTA . 'library/cropper/cropper.js"></script>';
        }

        if ($this->recaptcha) {
            $headerBody .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
        }
        $headerBody .= '</head>';

        echo $headerBody;
    }
    function navBar($navActive = '', $USERSYSTEM = false)
    {
        $navBarBody = '
            <header id="htc__header" class="htc__header__area header--one">
                <!-- Start Mainmenu Area -->
                <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                    <div class="container">
                        <div class="row">
                            <div class="menumenu__container clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
                                    <div class="logo">
                                        <a href="' . $this->RUTA . '"><img src="' . $this->IMG_LOGOS . '" alt="logo images"></a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-8 col-sm-5 col-xs-3">
                                    <nav class="main__menu__nav hidden-xs hidden-sm">
                                        <ul class="main__menu">
                                            <li class="drop"><a href="' . $this->RUTA . '">Home</a></li>
                                            <li class="drop"><a href="' . $this->RUTA . 'productos">Productos</a>
                                                <ul class="dropdown mega_dropdown">
                                                    <li><a class="mega__title" href="' . $this->RUTA . 'productos?sexo=man">Hombre</a>
                                                        <ul class="mega__item">
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=pantalon">Pantalones</a></li>
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=zapato">Zapatos vestir</a></li>
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=tenis">Zapatos tenis</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a class="mega__title" href="' . $this->RUTA . 'productos?sexo=woman">Mujer</a>
                                                        <ul class="mega__item">
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=pantalon">Falda</a></li>
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=pantalon">Vestidos</a></li>
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=pantalon">Pantalón</a></li>
                                                            <li><a href="' . $this->RUTA . 'productos?sexo=man&tipo=pantalon">Tacón</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>

                                    <div class="mobile-menu clearfix visible-xs visible-sm">
                                        <nav id="mobile_dropdown">
                                            <ul>
                                                <li><a href="' . $this->RUTA . '">Home</a></li>
                                                <li><a href="' . $this->RUTA . 'productos">Productos</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-2 col-sm-4 col-xs-4">
                                    <div class="header__right">
                                        <div class="header__search search search__open">
                                            <a href="#"><i class="icon-magnifier icons"></i></a>
                                        </div>
                                        <div class="header__account">
                                            <a href="' . $this->RUTA . 'login"><i class="icon-user icons"></i></a>
                                        </div>
                                        <div class="htc__shopping__cart">
                                            <a class="" href="' . $this->RUTA . 'carrito"><i class="icon-handbag icons"></i></a>
                                            <a href="' . $this->RUTA . 'carrito"><span class="htc__qua">2</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-menu-area"></div>
                    </div>
                </div>
                <!-- End Mainmenu Area -->
            </header>
            <div class="offset__wrapper">
                <!-- Start Search Popap -->
                <div class="search__area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="search__inner">
                                    <form action="search" method="get">
                                        <input name="q" placeholder="¿Qué estas buscando?" type="text">
                                        <button type="submit"></button>
                                    </form>
                                    <div class="search__close__btn">
                                        <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';

        echo $navBarBody;
    }
    function footer()
    {
        $footerBody = '
            <footer id="htc__footer">
                <div class="htc__copyright bg__cat--5">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="copyright__inner">
                                    <p>Copyright© 2020 Desarrollado <a href="https://crelosoftware.com.mx/">CRELO Software </a></p>
                                    <a href="#"><img src="' . $this->RUTA . 'library/asbab/images/others/shape/paypol.png" alt="payment images"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        ';
        echo $footerBody;
    }
    function scripts()
    {
        $scripsBody = '';
        if ($this->asbab) {
            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/vendor/jquery-3.2.1.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/bootstrap.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/plugins.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/slick.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/waypoints.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/owl.carousel.min.js"></script>';

            $scripsBody .= '<script src="' . $this->RUTA . 'library/asbab/js/main.js"></script>';
        }
        if ($this->bootstrap) {
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/popper.min.js"></script>';
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/bootstrap.min.js"></script>';
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/mdb.min.js"></script>';
            // $scripsBody .= '<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>';
        }
        $scripsBody .= '<script>  var RUTA ="' . $this->RUTA . '";</script>';

        if ($this->CERRAR_SESSION) {
            $scripsBody .= '<script src="' . $this->RUTA . 'js/login/cerrarSesion.js"></script>';
        }
        echo $scripsBody;
    }

    function navAdmin()
    {
        $cuerpoNavAdmin =
            '<nav class="main-header navbar navbar-expand navbar-white navbar-light">' .
            '<ul class="navbar-nav">' .
            '<li class="nav-item">' .
            '<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>' .
            '</li>' .
            '<li class="nav-item d-none d-sm-inline-block">' .
            '<a href="' . $this->RUTA . '" class="nav-link">Inicio</a>' .
            '</li>' .
            '<li class="nav-item d-none d-sm-inline-block">' .
            '<a href="' . $this->RUTA . 'productos" class="nav-link">Productos</a>' .
            '</li>' .
            '</ul>' .
            '<ul class="navbar-nav ml-auto">' .

            '<!-- Notifications Dropdown Menu -->' .
            '<li class="nav-item dropdown">' .
            '<a class="nav-link" data-toggle="dropdown" href="#">' .
            '<i class="fas fa-users-cog"></i>' .
            '</a>' .
            '<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">' .
            '<div class="dropdown-divider"></div>' .
            '<a href="' . $this->RUTA . 'sistema/account" class="dropdown-item">' .
            '<i class="fas fa-envelope mr-2"></i> Configurar' .
            '</a>' .
            '<div class="dropdown-divider"></div>' .
            '<a class="dropdown-item" id="cerrarSesion">' .
            '<i class="fas fa-sign-out-alt"></i> Cerrar Sesión' .
            '</a>' .
            '</div>' .
            '</li>' .
            '</ul>' .
            '</nav>';
        echo $cuerpoNavAdmin;
    }
    function sideBarAdmin($active = '')
    {
        $cuerpoSideBarAdmin =
            '<aside class="main-sidebar sidebar-dark-primary elevation-4">' .
            '<a href="' . $this->RUTA . 'sistema" class="brand-link">' .
            '<span class="brand-text font-weight-light">Control Almacen</span>' .
            '</a>' .
            '<div class="sidebar">' .
            '<div class="user-panel mt-3 pb-3 mb-3 d-flex">' .
            '<div class="info">' .
            '<a href="' . $this->RUTA . 'sistema/account" class="d-block">Leonardo Vázquez</a>' .
            '</div>' .
            '</div>' .
            '<nav class="mt-2">' .
            '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">' .
            '<li class="nav-item">' .
            '<a href="' . $this->RUTA . 'sistema/categorias" class="nav-link ' . (($active == 'categorias') ? "active" : "") . '">' .
            '<i class="far fa-circle nav-icon"></i>' .
            '<p>Categorias</p>' .
            '</a>' .
            '</li>' .
            '<li class="nav-item">' .
            '<a href="' . $this->RUTA . 'sistema/productos" class="nav-link ' . (($active == 'productos') ? "active" : "") . '">' .
            '<i class="far fa-circle nav-icon"></i>' .
            '<p>Productos</p>' .
            '</a>' .
            '</li>' .
            '<li class="nav-item"> 
                <a href="' . $this->RUTA . 'sistema/usuarios" class="nav-link ' . (($active == 'usuarios') ? "active" : "") . '"> 
                    <i class="far fa-circle nav-icon"></i> 
                    <p>Usuarios</p> 
                </a>
            </li>' .
            '<li class="nav-item"> 
                <a href="' . $this->RUTA . 'sistema/pedidos" class="nav-link ' . (($active == 'pedidos') ? "active" : "") . '"> 
                    <i class="far fa-circle nav-icon"></i> 
                    <p>Pedidos</p> 
                </a>
            </li>' .
            '</ul>' .
            '</nav>' .
            '</div>' .
            '</aside>';
        echo $cuerpoSideBarAdmin;
    }
}
