$(document).ready(function () {
    traer_productos();
    traer_productos_mas_vendidos();
    function traer_productos() {
        var contenedor = $("#container_productos");
        contenedor.html(`
            <tr>
                <td>
                    <div class="spinner-border text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
            </tr>
        `);
        $.ajax({
            type: "POST",
            url: RUTA + 'back/index',
            dataType: "json",
            data: `opcion=mostrar`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                console.log(data);
                if (data.respuesta == "exito") {
                    let modelo_p = new Producto();
                    let cuerpo = "";
                    let productos = data.productos;
                    for (const i in productos) {
                        let producto = productos[i].producto;
                        console.log(producto);
                        cuerpo += `<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">${modelo_p.cuerpo_producto(producto)}</div>`;
                    }
                    setTimeout(() => {
                        contenedor.html(cuerpo);
                        // add_producto();
                    }, 500);
                    // let PG = new Paginacion();
                    // PG.cuerpo_paginacion(pagina_actual, data.total);
                    // $(".paginacionTickets").on('click', function (e) {
                    //     pagina_actual = $(this).attr('data-id-page');
                    //     traerProductos();
                    // });
                } else {
                    $("#paginacion").html("");
                    contenedor.html(`<a class="dropdown-item" href="#">No hay resultados</a>`);
                }
            }
        });
    }
    function traer_productos_mas_vendidos() {
        var contenedor = $("#container_mas_vendidos");
        contenedor.html(`
            <tr>
                <td>
                    <div class="spinner-border text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
            </tr>
        `);
        $.ajax({
            type: "POST",
            url: RUTA + 'back/index',
            dataType: "json",
            data: `opcion=mostrar&limite=4`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                console.log(data);
                if (data.respuesta == "exito") {
                    let modelo_p = new Producto();
                    let cuerpo = "";
                    let productos = data.productos;
                    for (const i in productos) {
                        let producto = productos[i].producto;
                        console.log(producto);
                        cuerpo += `<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">${modelo_p.cuerpo_producto(producto)}</div>`;
                    }
                    setTimeout(() => {
                        contenedor.html(cuerpo);
                        // add_producto();
                    }, 500);
                    // let PG = new Paginacion();
                    // PG.cuerpo_paginacion(pagina_actual, data.total);
                    // $(".paginacionTickets").on('click', function (e) {
                    //     pagina_actual = $(this).attr('data-id-page');
                    //     traerProductos();
                    // });
                } else {
                    $("#paginacion").html("");
                    contenedor.html(`<a class="dropdown-item" href="#">No hay resultados</a>`);
                }
            }
        });
    }
    // function traer_productos() {
    //     let modelo_p = new Producto();
    //     let cuerpo = '';
    //     for (let i = 0; i < 16; i++) {
    //         cuerpo += `<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">${modelo_p.cuerpo_producto(1)}</div>`;
    //     }
    //     $("#container_productos").html(cuerpo);
    //     console.log(cuerpo);
    // }

    // function traer_productos_mas_vendidos() {
    //     let modelo_p = new Producto();
    //     let cuerpo = '';
    //     for (let i = 0; i < 4; i++) {
    //         cuerpo += `<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">${modelo_p.cuerpo_producto(1)}</div>`;
    //     }
    //     $("#container_mas_vendidos").html(cuerpo);
    //     // console.log(cuerpo);
    // }
});