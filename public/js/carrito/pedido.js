var mismo_vendedor = true;
$(document).ready(function () {
    verificar_carrito(localStorage.getItem("carrito"));
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

function vista_wish_list(listaCarrito) {
    console.log(listaCarrito);
    let func = new Funciones();

    let body_wish = '';
    if (listaCarrito) {
        let total_suma = 0;
        let total_productos = 0;
        let no_compra = false;
        listaCarrito.forEach(function (item, index) {//Revisa que existan coincidencias
            let costo = parseInt(item.costo);
            let cantidad = parseInt(item.cantidad);
            let total = costo * cantidad;
            total_productos += cantidad
            total_suma += total;
            body_wish += row_wish_list(item);
            no_compra = (!item.comprar) ? true : no_compra;
        });
        if (no_compra) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Udted tiene un producto en su carrito que no puede ser comprado, corrija el carrito y continue con su compra',
                footer: `<a href="${RUTA}carrito">Corregir</a>`
            });
        }
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
    <div class="single-item p-0">
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

function verificar_carrito(carrito) {
    $.ajax({
        type: "POST",
        url: RUTA + 'back/carrito',
        dataType: "json",
        data: `opcion=comprobar_productos_carrito&carrito=${carrito}`,
        error: function (xhr, resp) {
            console.log(xhr.responseText);
        },
        success: function (data) {
            console.log(data);
            if (data.respuesta == 'exito') {
                $("#table_carrito").html(vista_wish_list(data.carrito));
                localStorage.setItem("carrito", JSON.stringify(data.carrito));
            } else {
                Swal.fire('Opss', data.Texto, 'error');
                localStorage.removeItem('carrito');
            }
        }
    });
}