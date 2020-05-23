<?php

use App\Models\{Templates, Administrador, Clientes};
use App\Models\{Usuarios};


$TEMPLATES = new Templates();
$ADMIN = new Administrador();
$CLIENTES = new Clientes();

// $user_info = $USER->buscarUsuario($USERSYSTEM['idUsuario']);
$user_info = ($USERSYSTEM) ? $CLIENTES->mostrar_cliente($USERSYSTEM['idUsuario'], $USERSYSTEM['cargo']) : false;

$TEMPLATES->TITULO =      'Completar compra  | ' . $TEMPLATES->SISTEMNAME;
$TEMPLATES->DESCRIPCION = 'Registrar mi compra | ' . $TEMPLATES->DESCRIPCION;
$TEMPLATES->KEYWORDS =    'Finalizar compra | ' . $TEMPLATES->KEYWORDS;

$TEMPLATES->header();
$fecha = date('d') . ' de ' . $ADMIN->MESES((int) date('m')) . ' de ' . date('Y');
?>

<body>
    <header class="site-navbar site-navbar-target pb-0" role="banner">
        <?php echo $TEMPLATES->navBar('carrito', $USERSYSTEM); ?>
    </header>
    <div class="checkout-wrap ptb--100">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="checkout__inner">
                        <div class="accordion-list">
                            <div class="accordion">
                                <div class="accordion__title">
                                    Información de envio
                                </div>
                                <div class="accordion__body">
                                    <div class="bilinfo">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="single-input mt-0">
                                                        <select name="bil-country" id="bil-country">
                                                            <option value="select">Select your country</option>
                                                            <option value="arb">Arab Emirates</option>
                                                            <option value="ban">Bangladesh</option>
                                                            <option value="ind">India</option>
                                                            <option value="uk">United Kingdom</option>
                                                            <option value="usa">United States</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="First name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="Last name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="Company name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="Street Address">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="Apartment/Block/House (optional)">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="City/State">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="Post code/ zip">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-input">
                                                        <input type="email" placeholder="Email address">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-input">
                                                        <input type="text" placeholder="Phone number">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="accordion__title">
                                    Información de envio
                                </div>
                                <div class="accordion__body">
                                    <div class="shipinfo">
                                        <h3 class="shipinfo__title">Dirección de envio</h3>
                                        <p><b>Dirección:</b> Bootexperts, Banasree D-Block, Dhaka 1219, Bangladesh</p>
                                    </div>
                                </div>
                                <div class="accordion__title">
                                    shipping method
                                </div>
                                <div class="accordion__body">
                                    <div class="shipmethod">
                                        <form action="#">
                                            <div class="single-input">
                                                <p>
                                                    <input type="radio" name="ship-method" id="ship-fast">
                                                    <label for="ship-fast">First shipping</label>
                                                </p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid voluptatum quaerat totam hic suscipit quam repellat debitis ad sed aperiam quisquam quibusdam enim labore, ipsa illo, natus ipsam temporibus officia.</p>
                                            </div>
                                            <div class="single-input">
                                                <p>
                                                    <input type="radio" name="ship-method" id="ship-normal">
                                                    <label for="ship-normal">Normal shipping</label>
                                                </p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam maxime, eaque eos! Quidem officia similique, fuga consequatur vero? Quis autem dicta voluptatibus veniam temporibus rem reprehenderit placeat quaerat sunt ducimus.</p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="accordion__title">
                                    payment information
                                </div>
                                <div class="accordion__body">
                                    <div class="paymentinfo">
                                        <div class="single-method">
                                            <a href="#"><i class="zmdi zmdi-long-arrow-right"></i>Check/ Money Order</a>
                                        </div>s
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="order-details">
                        <h5 class="order-details__title">Tu pedido</h5>
                        <div class="order-details__item" id="table_carrito">
                            <div class="single-item">
                                <div class="single-item__thumb">
                                    <img src="images/cart/1.png" alt="ordered item">
                                </div>
                                <div class="single-item__content">
                                    <a href="#">Santa fe jacket for men</a>
                                    <span class="price">$128</span>
                                </div>
                            </div>
                        </div>
                        <div class="order-details__count">
                            <div class="order-details__count__single">
                                <h5>Total productos</h5>
                                <span class="price" id="total_productos">$909.00</span>
                            </div>
                            <div class="order-details__count__single">
                                <h5>Costo total</h5>
                                <span class="price" id="total_compra">$9.00</span>
                            </div>
                            <div class="order-details__count__single">
                                <h5>Envio</h5>
                                <span class="price">150</span>
                            </div>
                        </div>
                        <div class="ordre-details__total">
                            <h5>Order total</h5>
                            <span class="price" id="total_envio"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $TEMPLATES->footer(); ?>

    <?php $TEMPLATES->scripts(); ?>
    <script>
        $(document).ready(function() {
            $("#print_nota").on('click', function() {
                window.addEventListener("load", window.print());
            })
        });
    </script>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/carrito/carrito.js"></script>
    <script src="<?php echo $RUTA; ?>js/carrito/pedido.js"></script>

</body>

</html>