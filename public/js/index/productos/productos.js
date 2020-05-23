$(document).ready(function () {


    var filtro_categoria = $("#categoria").val();
    var filtro_busqueda = $("#search_filter").val();
    var pagina_actual = 1;
    var filtro_costo = false;
    traerCategorias();
    traerProductos();

    if ($(document).width() < 768) {
        $(".min_filtro").each(function () {
            let button = $(this);
            button.html('<i class="fas fa-plus"></i>')
            button.attr('data-status', 'in');
            button.parent().parent().children('.contenido').hide();
        });
    }
    function traerCategorias() {
        estado_edicion = true;
        let contenedor = $("#categorias_list");
        $.ajax({
            type: "POST",
            url: RUTA + 'back/categorias',
            dataType: "json",
            data: `opcion=mostrar`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let cuerpo = "";
                    cuerpo += `<li class="filter-list"><a href="${RUTA}productos/">Todas</a></li>`;
                    let categorias = data.categorias;
                    for (const i in categorias) {
                        let categoria = categorias[i].categoria;
                        cuerpo += `<li class="filter-list"><a href="?categoria=${categoria.id}">${categoria.categoria}<span>(${categorias[i].total_productos})</span></a></li>`;
                    }
                    contenedor.html(cuerpo);
                } else {
                    contenedor.html(`<a class="dropdown-item" href="">No</a>`);
                }
            }
        });
    }

    $("#filter_price").on('click', function (e) {
        e.preventDefault();
        filtro_costo = $("#amount").val();
        traerProductos();
    });


    function traerProductos() {
        let categoria = ((filtro_categoria != "") ? `&categoria=${filtro_categoria}` : "");
        let busqueda = ((filtro_busqueda != "") ? '&busqueda=' + filtro_busqueda : "");
        let actual = ((pagina_actual != "") ? '&pagina=' + pagina_actual : "");
        let precios = ((filtro_costo) ? '&filtro_costo=' + filtro_costo : "");
        let filtros = categoria + busqueda + actual + precios;
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
            data: `opcion=mostrar${filtros}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let modelo_p = new Producto();
                    let cuerpo = "";
                    let productos = data.productos;
                    for (const i in productos) {
                        let producto = productos[i].producto;
                        cuerpo += `<div class="col-sm-4 col-xs-6">${modelo_p.cuerpo_producto(producto)}</div>`;
                    }
                    setTimeout(() => {
                        contenedor.html(cuerpo);
                        add_producto();
                    }, 500);
                    let PG_C = new Paginacion();
                    $("#paginacion").html(PG_C.cuerpo_paginacion(pagina_actual, data.total, 'productos'));
                    $(".paginacion_productos").on('click', function (e) {
                        pagina_actual = $(this).attr('data-id-page');
                        traerProductos();
                    });
                } else {
                    $("#paginacion").html("");
                    contenedor.html(`<a class="dropdown-item" href="#">No hay resultados</a>`);
                }
            }
        });
    }

});