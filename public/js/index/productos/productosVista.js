$(document).ready(function () {
    let precio = $("#precio_venta");
    let costo = precio.attr('data-precio');
    precio.html("$ " + number_format(parseInt(costo), 2));
    let product_wish = $("#product_wish");

    let evento = producto_carrito(parseInt(product_wish.attr('data-id')));
    product_wish.html(`${(!evento ? '<i class="far fa-heart ml-3 h1"></i>' : '<i class="fas fa-plus-circle ml-3 text-success" ></i>')}`);


    traerProductos();
    function traerProductos(buscar = "") {
        let busqueda = ((buscar != "") ? '&busqueda=' + buscar : "");
        var contenedor = $("#cont_carousel");
        $.ajax({
            type: "POST",
            url: RUTA + 'views/productos/php/ajax.php',
            dataType: "json",
            data: `opcion=mostrar${busqueda}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let cuerpo = "";
                    let productos = data.productos;
                    for (const i in productos) {
                        if (productos[i].producto.id != id_producto) {
                            cuerpo += `<div class="item">${card_Producto(productos[i])}</div>`;
                        }
                    }
                    setTimeout(() => {
                        contenedor.html(`<div class="owl-carousel owl-theme">${cuerpo}</div>`);
                        $('.owl-carousel').owlCarousel({
                            autoplay: true,
                            autoplayTimeout: 2000,
                            loop: true,
                            margin: 10,
                            nav: true,
                            responsive: {
                                0: {
                                    items: 2
                                },
                                600: {
                                    items: 3
                                },
                                1000: {
                                    items: 4
                                }
                            }
                        });
                        add_producto();
                    }, 500);
                }
            }
        });
    }
    function card_Producto(producto_total) {
        let producto = producto_total.producto;
        let oferta = producto_total.oferta;
        let cuerpo = `
        <div class="">
            <div class="card text-center card-product">
                <div class="card-product__img">
                    <img class="card-img" src="${RUTA}documents/Galery/productos/${producto.imagen}" alt="">
                    <ul class="card-product__imgOverlay">
                        <li><a href="${RUTA}productos/${producto.id}/${removeSpecialChars(normalize(producto.nombre))}"><i class="fas fa-eye"></i></a></li>
                        <li data-id="${producto.id}" data-name="${producto.nombre}" data-costo="${number_format(producto.precio_venta, 2)}" data-img="${producto.imagen}" data-vendedor="${producto.id_usuario}" data-vendedor-nombre="${producto.nombre_vendedor}">
                            <button class="addWishList">
                                ${(!producto_carrito(producto.id) ? '<i class="fas fa-cart-plus"></i>' : '<i class="fas fa-plus-circle text-white"></i>')}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <p>${producto.categoria}</p>
                    <h6 class="card-product__title"><a href="${RUTA}productos/${producto.id}/${removeSpecialChars(normalize(producto.nombre))}">${producto.nombre}</a></h6>
                    <p class="card-product__price">$ ${number_format(producto.precio_venta, 2)} MXN</p>
                </div>
            </div>
        </div>`;
        return cuerpo;
    }


});