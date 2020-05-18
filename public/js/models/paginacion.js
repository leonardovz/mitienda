class Paginacion {

    cuerpo_paginacion(pagina, paginas, name = 'default') {
        pagina = parseInt(pagina);
        let total = paginas,
            elementos = 12;//Numero de elementos que esta limitado para la impresión de elementos
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

        var cuerpo = `<ul class="htc__pagenation">`;
        cuerpo += ` <li class="page-item ${((pagina <= 1) ? " disabled" : "")}"><a class="page-link paginacion_${name}" ${((pagina <= 1) ? "" : 'data-id-page="' + (pagina - 1) + '"')}><i class="zmdi zmdi-chevron-left"></i></a></a></li>`;

        if (pagina >= elementosCard) {
            cuerpo += `<li class="page-item ${((pagina <= 1) ? " disabled" : "")}"><a class="page-link paginacion_${name}" data-id-page="1">1.. </a></li>`;
        }

        for (i; i <= limite; i++) {
            cuerpo += `<li class="page-item ${((i == pagina) ? " active" : " ")}"><a class="page-link ${((i == pagina) ? '' : `paginacion_${name}`)} " data-id-page="${i} ">${i}</a></li>`;
        }
        cuerpo += `<li class="page-item ${((pagina >= paginas) ? " disabled" : "")}" ><a class="page-link paginacion_${name}" ${((pagina >= paginas) ? "" : 'data-id-page="' + (parseInt(pagina) + 1) + '"')} ><i class="zmdi zmdi-chevron-right"></i></a></li>`;
        cuerpo += (pagina != paginas) ? `<li class="page-item ${((pagina >= paginas) ? " disabled" : "")}" ><a class="page-link paginacion_${name}" data-id-page="${paginas}"><i class="fa fa-fast-forward" aria-hidden="true"></i> </a></li>` : "";
        cuerpo += `</ul>`;
        return cuerpo;
    }
}