$(document).ready(function () {
    var pagina_actual = 1;
    var estado_pedido = '';
    traer_tickets();
    $("#estado_pedido").change(function () {
        estado_pedido = $(this).val();
        pagina_actual = 1
        traer_tickets();
    });

    function traer_tickets() {
        let contenedor = $("#content_pedidos");
        contenedor.html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');

        $.ajax({
            type: "POST",
            url: RUTA + 'back/pedidos',
            dataType: "json",
            data: `opcion=pedidos_vendedor&pagina=${pagina_actual}&estado=${estado_pedido}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                console.log(data);
                if (data.respuesta == "exito") {
                    let cuerpo = "";
                    for (const i in data.pedidos) {
                        cuerpo += row_pedido(data.pedidos[i]);
                    }
                    setTimeout(() => {
                        contenedor.html(`
                        <table class="table table-striped projects">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 1%"> Folio</th>
                                    <th>Progreso </th>
                                    <th style="width: 5%" class="text-center">Vendedor </th>
                                    <th style="width: 5%" class="text-center"> Repartidor </th>
                                    <th style="min-width: 180px; width: 20%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${cuerpo}
                            </tbody>
                        </table>`);
                        paginar(pagina_actual, data.total);
                        $(".paginacion_tickets").on('click', function (e) {
                            pagina_actual = $(this).attr('data-id-page');
                            traer_tickets();
                        });
                        accion();
                    }, 600);

                } else {
                    setTimeout(() => {
                        contenedor.html(`
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Opss!</h4>
                            <p>La busqueda que intentaste realizar no obtubo resultados, o nocuentas con pedidos para verificar</p>
                            <hr>
                            <p class="mb-0">${data.Texto}</p>
                        </div>
                        `);
                    }, 600);
                }
            }
        });
    }


    function row_pedido(pedido) {
        let ticket = pedido.pedido;
        let valores = config_estado(ticket.status);
        let color = valores.color;
        let valor = valores.valor;
        let next_valor = next_estado(ticket.status);
        let FUNC = new Funciones();
        let cuerpo = `
        <tr>
            <td>${FUNC.rellenarCero(ticket.id, 7)}</td>
            <td class="project_progress">
                <div class="progress progress-sm">
                    <div class="progress-bar ${color}" role="progressbar" aria-volumenow="${valor}" aria-volumemin="0" aria-volumemax="100" style="width: ${valor}%">
                    </div>
                </div>
                <small>
                    ${valor}% ${ticket.status}
                </small>
            </td>
            <td class="project-state">
                <a ${ticket.id_vendedor > 0 ? `href="${RUTA}perfil/${FUNC.rellenarCero(ticket.id_vendedor)}" target="_blank"` : ""} class="h3"><i class="fab fa-mendeley fa-rotate-180 ${ticket.id_vendedor > 0 ? "text-success" : ""}"></i></a>
            </td>
            <td>
               <a ${ticket.id_repartidor > 0 ? `href="${RUTA}perfil/${FUNC.rellenarCero(ticket.id_repartidor)}" target="_blank"` : ""}  class="h3"><i class="fas fa-motorcycle ${ticket.id_repartidor > 0 ? "text-success" : ""}"></i></a>
            </td>
            <td class="project-actions text-right" data-id-pedido="${ticket.id}" data-next-estado="${next_valor.next}">
                ${ticket.status == "pendiente" ? `<a class="btn btn-danger btn-sm px-2 cancelar_pedido" ><i class="fas fa-trash"></i>Cancelar</a>` : ""}
                ${ticket.status != 'cancelado' ? `<a class="btn ${next_valor.color} btn-sm x-2  ${ticket.status != 'recibido' ? "update_pedido" : ""}" ><i class="${next_valor.icon} mx-2"></i>${next_valor.texto}</a>` : ""}
                <a class="btn btn-primary btn-sm px-2" href="${RUTA}carrito/ticket/${ticket.id}" target="_blank"> <i class="fas fa-folder"></i>Ver </a>
            </td>
        </tr>
        `;
        return cuerpo;

    }
    function paginar(pagina, paginas) {
        pagina = parseInt(pagina);
        let total = paginas,
            elementos = 10;//Numero de elementos que esta limitado para la impresión de elementos
        if (true) {
            paginas = ((total % elementos) > 0) ? Math.trunc(total / elementos) + 1 : Math.trunc(total / elementos)
        }
        if (pagina > paginas) {
            pagina = 1;
        }
        var elementosCard = 8; //Numero de elementos para realizar la paginación
        // var recorrido = (paginas > elementosCard) ? (((paginas % elementosCard) > 0) ? Math.trunc(paginas / elementosCard) + 1 : Math.trunc(paginas / elementosCard)) : paginas;
        var i = (Math.trunc(pagina / elementosCard)) * elementosCard;
        var limite = i + elementosCard;
        if ((pagina + elementosCard) > paginas) { //Validar que los elementos no sobrepasen el limite
            i = paginas - elementosCard; //Asignación inicio del ciclo
            limite = paginas //Asignación fin del ciclo
        }
        i = (i < 1) ? 1 : i;

        var cuerpo = `<ul class="pagination">`;
        cuerpo += ` <li class="page-item ${((pagina <= 1) ? " disabled" : "")}"><a class="page-link paginacion_tickets" ${((pagina <= 1) ? "" : 'data-id-page="' + (pagina - 1) + '"')}>Previous</a></li>`;

        if (pagina >= elementosCard) {
            cuerpo += `<li class="page-item ${((pagina <= 1) ? " disabled" : "")}"><a class="page-link paginacion_tickets" data-id-page="1">1.. </a></li>`;
        }

        for (i; i <= limite; i++) {
            cuerpo += `<li class="page-item ${((i == pagina) ? " active" : " ")}"><a class="page-link ${((i == pagina) ? '' : 'paginacion_tickets')} " data-id-page="${i} ">${i}</a></li>`;
        }
        cuerpo += `<li class="page-item ${((pagina >= paginas) ? " disabled" : "")}" ><a class="page-link paginacion_tickets" ${((pagina >= paginas) ? "" : 'data-id-page="' + (parseInt(pagina) + 1) + '"')} >Next</a></li>`;
        cuerpo += (pagina != paginas) ? `<li class="page-item ${((pagina >= paginas) ? " disabled" : "")}" ><a class="page-link paginacion_tickets" data-id-page="${paginas}"><i class="fa fa-fast-forward" aria-hidden="true"></i> </a></li>` : "";
        cuerpo += `</ul>`;
        $("#paginacion").html(cuerpo);
    }
    function accion() {
        $(".cancelar_pedido").on('click', function () {
            let id_pedido = $(this).parent().attr('data-id-pedido');
            console.log(id_pedido); Swal.fire({
                title: '¿Estas seguro?',
                text: "Esta acción no tiene vuelta",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si,Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: RUTA + 'back/pedidos',
                        dataType: "json",
                        data: `opcion=cancelar_pedido&id_pedido=${id_pedido} `,
                        error: function (xhr, resp) {
                            console.log(xhr.responseText);
                        },
                        success: function (data) {
                            if (data.respuesta == 'exito') {
                                Swal.fire('¡Exelente!', data.Texto, 'success');
                                traer_tickets();
                            } else {
                                Swal.fire('Opss!', data.Texto, 'error');
                            }
                        }
                    });
                }
            })

        });
        $(".update_pedido").on('click', function () {
            let id_pedido = $(this).parent().attr('data-id-pedido');
            let next_estado = $(this).parent().attr('data-next-estado');
            console.log(id_pedido);
            Swal.fire({
                title: '¿Seguro que quieres continuar?',
                text: "No podras realizar cancelación del pedido",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, continuar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: RUTA + 'back/pedidos',
                        dataType: "json",
                        data: `opcion=actualizar_pedido&id_pedido=${id_pedido}&estado=${next_estado}`,
                        error: function (xhr, resp) {
                            console.log(xhr.responseText);
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.respuesta == 'exito') {
                                Swal.fire('¡Exelente!', data.Texto, 'success');
                                traer_tickets();
                            } else {
                                Swal.fire('Opss!', data.Texto, 'error');
                            }
                        }
                    });
                }
            })

        });
    }
});