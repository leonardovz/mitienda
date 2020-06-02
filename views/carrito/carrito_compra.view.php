<?php

use App\Models\{Templates, Administrador, Clientes};


$TEMPLATES = new Templates();
$ADMIN = new Administrador();
$CLIENTES = new Clientes();

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
                                    Metodo de pago
                                </div>
                                <div class="accordion__body">
                                    <div class="paymentinfo">
                                        <div class="single-method">
                                            <?php
                                            MercadoPago\SDK::setAccessToken('TEST-3296678210453498-052323-a6632f22bb2b15ddc2f8841c4b1ccdd2-208604661');

                                            // Crea un objeto de preferencia
                                            $preference = new MercadoPago\Preference();

                                            // Crea un ítem en la preferencia
                                            $item = new MercadoPago\Item();
                                            $item->title = 'Pago: ticket: 50452F12DD';
                                            $item->quantity = 1;
                                            $item->unit_price = 52.00;
                                            $preference->items = array($item);
                                            $preference->save(); ?>
                                            <form action="/procesar_pago" method="POST">
                                                <script src="https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js" data-preference-id="<?php echo $preference->id; ?>">
                                                </script>
                                            </form>
                                        </div>
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
                            <div class="loader">Loading...</div>
                        </div>
                        <div class="order-details__count">
                            <div class="order-details__count__single">
                                <h5>Total productos</h5>
                                <span class="price" id="total_productos">$0.00</span>
                            </div>
                            <div class="order-details__count__single">
                                <h5>Costo total</h5>
                                <span class="price" id="total_compra">$0.00</span>
                            </div>
                            <div class="order-details__count__single">
                                <h5>Envio</h5>
                                <span class="price">$ 0.00</span>
                            </div>
                        </div>
                        <div class="ordre-details__total">
                            <h5>Orden total</h5>
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