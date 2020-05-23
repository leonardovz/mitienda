$(document).ready(function () {
    mostrarWish();
});

function mostrarWish() {
    $("#cont_wish_list").html(vista_wish_list());
    action_wish();
}

function vista_wish_list() {
    let func = new Funciones();
    let body_wish = '';
    if (localStorage.carrito) {
        var listaCarrito = JSON.parse(localStorage.getItem("carrito"));
        let total_suma = 0;
        let total_productos = 0;
        listaCarrito.forEach(function (item, index) {//Revisa que existan coincidencias
            let costo = parseInt(item.costo);
            let cantidad = parseInt(item.cantidad);
            let total = costo * cantidad;
            total_productos += cantidad
            total_suma += total;
            body_wish += row_wish_list(item);
        });
        $("#total_productos").html(total_productos);
        $("#total_compra").html('$ ' + func.number_format(total_suma, 2));
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
        <div class="row">
            <div class="col-md-12">
                <div class="card my-2 w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-xs-3" style="padding: 10px 0 0 10px;"><img src="${producto.img}" alt="" class="img-fluid w-100" style="width: 100%; max-width: 100px"></div>
                            <div class="col-md-10 col-xs-9 " style="padding: 0 30px 0 10px;">
                                <h5>${producto.name}</h5>
                                <p class="text-muted">
                                    <b class="h5 text-muted">
                                        ${cantidad}
                                    </b>
                                    Unidad${cantidad > 1 ? "es" : ""}
                                </p>
                                <p class="text-right">
                                    <div class="btn-group radio-group ml-2" data-id="${producto.id}" data-cantidad="${producto.cantidad}">
                                        <a href="" class="action_wish" style="margin:10px 10px;" data-action="remove"> <i class="fas fa-minus-circle"></i> </a>
                                        <a href="" class="action_wish" style="margin:10px 10px;" data-action="add"><i class="fas fa-plus-circle"></i></a>
                                        <a href="" class="action_wish" style="margin:10px 10px;" data-action="delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </p>
                                <p class="h5 text-right">$ ${func.number_format(total, 2)}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

    `;
    return cuerpo;
}
function action_wish() {
    $(".action_wish").on('click', function (e) {
        e.preventDefault();

        let button = $(this);
        let action = button.attr('data-action');
        let id = parseInt(button.parent().attr('data-id'));
        let cantidad = parseInt(button.parent().attr('data-cantidad'));
        if (action == "remove") {
            cantidad = cantidad - 1;
            actualizar_cantidad(id, cantidad);
        } else if (action == "add") {
            cantidad = cantidad + 1;
            actualizar_cantidad(id, cantidad);
        } else if (action == "delete") {
            actualizar_cantidad(id, 0);
        }
        contar_productos();
    });
}

function actualizar_cantidad(idProd, cantidad) {
    var nuevaVersion = [];
    var listaCarrito = JSON.parse(localStorage.getItem("carrito"));

    if (listaCarrito) {
        nuevaVersion = [];
        listaCarrito.forEach(function (item, index) {
            let enviar = true; //Para hacer push si es mayor a 0
            var idproducto = item.id;
            if (idproducto == idProd) {
                item.cantidad = cantidad;
                if (cantidad < 1) {
                    enviar = false;
                }
            }
            if (enviar) {
                nuevaVersion.push(item);
            }
        });
        localStorage.setItem("carrito", JSON.stringify(nuevaVersion));
        mostrarWish();
    }
}