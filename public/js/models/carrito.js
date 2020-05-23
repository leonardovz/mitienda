
function add_producto() {
    $(".addWishList").off().on('click', function (e) {
        e.preventDefault();
        let button = $(this);
        let parent = button.parent();
        let message = "";

        let idProd = parent.attr('data-id');
        let name = parent.attr('data-name');
        let costo = parent.attr('data-costo');
        let img = parent.attr('data-img');

        let producto = {
            "id": idProd,
            "name": name,
            "costo": costo,
            "img": img,
            "cantidad": 1,
        };

        if (localStorage.carrito) {
            var nuevaVersion = [];
            var listaCarrito = JSON.parse(localStorage.getItem("carrito"));
            let coincidir = false;
            listaCarrito.forEach(function (item, index) {//Revisa que existan coincidencias
                var idproducto = item.id;
                if (idproducto == idProd) {
                    coincidir = true;
                }
                nuevaVersion.push(item);//Llena el arreglo
            });

            if (!coincidir) {
                listaCarrito.push(producto);
                nuevaVersion = listaCarrito;
                message = `Se añadio ${name} a tu carrito`;
            } else {
                nuevaVersion = [];
                listaCarrito.forEach(function (item, index) {
                    var idproducto = item.id;
                    if (idproducto == idProd) {
                        item.cantidad = item.cantidad + 1;
                        item.img = img;
                    }
                    nuevaVersion.push(item);
                });
                message = `+1 ${name}`;

            }

            localStorage.setItem("carrito", JSON.stringify(nuevaVersion));

        } else {
            localStorage.setItem('carrito', JSON.stringify([producto]));
            message = `Se añadio ${name} a tu carrito`;
        }
        // console.log(JSON.parse(localStorage.getItem("carrito")));
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 1500
        });
        contar_productos();

    });
}
function producto_carrito(id) {
    let coincidir = false;
    if (localStorage.carrito) {
        var listaCarrito = JSON.parse(localStorage.getItem("carrito"));
        listaCarrito.forEach(function (item, index) {//Revisa que existan coincidencias
            var idproducto = item.id;
            if (idproducto == id) {
                coincidir = true;
            }
        });
    }
    return coincidir;
}
