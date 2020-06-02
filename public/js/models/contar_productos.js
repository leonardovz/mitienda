$(document).ready(function () {
    contar_productos();
});
function contar_productos() {
    let listaCarrito = JSON.parse(localStorage.getItem("carrito"));
    if (listaCarrito) {
        $("#carrito_compras").html(listaCarrito.length);
    }
}