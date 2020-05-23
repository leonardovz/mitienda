var mismo_vendedor = true;
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
                    url: RUTA + 'back/pedidos',
                    dataType: "json",
                    data: `opcion=crear&${formulario}&carrito=${carrito}`,
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
    $("#table_carrito").html(vista_wish_list());
}

function vista_wish_list() {
    let func = new Funciones();

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
        $("#total_productos").html(total_productos);
        $("#total_compra").html('$ ' + func.number_format(total_suma, 2));
        $("#total_envio").html('$ ' + func.number_format(total_suma + 150, 2));
    }
    return body_wish;
}

function row_wish_list(producto) {
    let func = new Funciones();

    let cuerpo = '';
    let costo = parseInt(producto.costo);
    let cantidad = parseInt(producto.cantidad);
    let total = costo * cantidad;
    cuerpo = `
    <div class="single-item">
        <div class="single-item__thumb">
            <img src="${producto.img}" alt="ordered item">
        </div>
        <div class="single-item__content">
        ${cantidad}- <a class="ml-2"> ${producto.name}</a>
            <span class="price">$ ${func.number_format(total, 2)}</span>
        </div>
    </div>
    
    `;
    return cuerpo;
}

