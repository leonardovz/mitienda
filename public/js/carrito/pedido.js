var mismo_vendedor = true;
var global_vendedor = 0;
$(document).ready(function () {
    mostrar_pedido();
    $("#enviar_pedido").on('submit', function (e) {
        e.preventDefault();
        let formulario = $(this).serialize();
        let carrito = localStorage.carrito;
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Estas apunto de notificar al vendedor!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, hacer pedido!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: RUTA + 'views/sistema/pedidos/php/pedidos.php',
                    dataType: "json",
                    data: `opcion=crear&${formulario}&carrito=${carrito}&idVendedor=${global_vendedor}`,
                    error: function (xhr, resp) {
                        console.log(xhr.responseText);
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.respuesta == "exito") {
                            Swal.fire({
                                title: data.Texto,
                                text: "Borrar mi carrito de compras",
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Conservar carrito',
                                confirmButtonText: 'Limpiar'
                            }).then((result) => {
                                if (result.value) {
                                    localStorage.removeItem('carrito');
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Puedes armar un nuevo carrito',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    window.open(RUTA + "carrito/ticket/" + data.pedido, "Diseño Web", "width=800, height=1200");
                                    setTimeout(() => {
                                        location.href = RUTA + "sistema/mispedidos";
                                    }, 1000);
                                } else {
                                    window.open(RUTA + "carrito/ticket/" + data.pedido, "Diseño Web", "width=800, height=1200");
                                    setTimeout(() => {
                                        location.href = RUTA + "sistema/mispedidos";
                                    }, 1000);
                                }
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                data.Texto,
                                'warning'
                            );
                        }
                    }
                });
            }
        });

    });
});

function verificar_vendedor() {
    $("#alerta_vendedor").html(`
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Oye amig@!</h4>
                <p>
                    Al paraecer tus productos son de diferentes vendedores, el unico tipo de envio que puedes tener es por parte de un repartidor.<br>
                    Para pedir tus productos o recerbarlos es necesario que modifiques tu carrito
                </p>
                <hr>
                <a href="${RUTA}carrito" class="mb-0">Modificar mi carrito.</a>
            </div>`);
}

function mostrar_pedido() {
    $("#table_carrito").html(`
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10%;">Cantidad</th>
                    <th style="width: 50%;">Producto</th>
                    <th style="width: 15%;">Precio</th>
                    <th style="width: 15%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                ${vista_wish_list()}
            </tbody>
        </table>`
    );
}

function vista_wish_list() {
    let body_wish = '';
    if (localStorage.carrito) {
        var listaCarrito = JSON.parse(localStorage.getItem("carrito"));
        let total_suma = 0;
        let total_productos = 0;
        let id_vendedor = false;
        listaCarrito.forEach(function (item, index) {//Revisa que existan coincidencias
            let costo = parseInt(item.costo);
            let cantidad = parseInt(item.cantidad);
            let total = costo * cantidad;
            total_productos += cantidad
            total_suma += total;
            body_wish += row_wish_list(item);
            if (id_vendedor) {
                if (id_vendedor != item.vendedor) {
                    mismo_vendedor = false;
                    $("#yo_ire").attr('disabled', 'disabled').removeAttr('checked');
                    $("#envio_vendedor").attr('disabled', 'disabled');
                    $("#trae_repartidor").attr('checked', 'checked');
                    verificar_vendedor();
                }
            }
            id_vendedor = item.vendedor;
        });
        global_vendedor = (mismo_vendedor) ? id_vendedor : 0;
        console.log(global_vendedor);
        $("#total_productos").html(total_productos);
        $("#total_compra").html('$ ' + number_format(total_suma, 2));
    }
    return body_wish;
}

function row_wish_list(producto) {
    let cuerpo = '';
    let costo = parseInt(producto.costo);
    let cantidad = parseInt(producto.cantidad);
    let total = costo * cantidad;
    cuerpo = `
    <tr>
        <td>${cantidad}</td>
        <td> ${producto.name}</td>
        <td>$ ${number_format(costo, 2)}</td>
        <td>$ ${number_format(total, 2)}</td>
    </tr>
    `;
    return cuerpo;
}

