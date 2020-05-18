$(document).ready(function () {
    traerCategorias();

    $("#nuevo_producto").on('click', function () {
        $("#contForm").show();
    })
    $("#producto_cancelar").on('click', function () {
        $("#contForm").hide();
    })
    var filtro_tipo = "";
    var filtro_categoria = "";
    var filtro_busqueda = "";
    var pagina_actual = 1;
    function traerCategorias() {
        estado_edicion = true;
        let contenedor = $("#menu_categoria");
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
                    let categorias = data.categorias;
                    cuerpo += `<option value=""> Todos </option>`;
                    for (const i in categorias) {
                        let categoria = categorias[i].categoria;
                        cuerpo += `<option value="${categoria.id}" > ${categoria.categoria} </option>`;
                    }
                    contenedor.html(cuerpo);
                    $("#selCategoria").html(cuerpo);
                    $("#menu_categoria").change(function () {
                        filtro_categoria = $(this).val();
                        pagina_actual = 1;
                        traerProductos();
                    });
                } else {
                    contenedor.html(`<a class="dropdown-item" href="#">No</a>`);
                }
            }
        });
    }

    traerProductos();
    filtros();

    function traerProductos() {
        let tipo = ((filtro_tipo != "") ? `&tipo=${filtro_tipo}` : "");
        let categoria = ((filtro_categoria != "") ? `&categoria=${filtro_categoria}` : "");
        let busqueda = ((filtro_busqueda != "") ? '&busqueda=' + filtro_busqueda : "");
        let actual = ((pagina_actual != "") ? '&pagina=' + pagina_actual : "");
        let filtros = tipo + categoria + busqueda + actual;
        var contenedor = $("#cont_body_table");
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
            url: RUTA + 'back/productos',
            dataType: "json",
            data: `opcion=mostrar${filtros}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let FUNC = new Funciones();
                    let cuerpo = "";
                    let productos = data.productos;
                    for (const i in productos) {
                        let producto = productos[i].producto;
                        let estado = 'success';
                        estado = producto.estado == 'inactivo' ? "danger" : estado;
                        estado = producto.estado == 'oferta' ? "warning" : estado;
                        cuerpo += `F
                            <tr>
                                <td>
                                    <div class="product-img">
                                        <img src="${producto.url_img}" alt="Product Image" class="img-size-50">
                                    </div>
                                </td>
                                <td><a href="${RUTA}productos/${producto.id}/${FUNC.removeSpecialChars(FUNC.normalize(producto.nombre))}">${producto.codigo}</a></td>
                                <td>${producto.nombre}</td>
                                <td>${producto.categoria}</td>
                                <td>${producto.stock}</td>
                                <td>$ ${FUNC.number_format(producto.precio_compra, 2)}</td>
                                <td>$ ${FUNC.number_format(producto.precio_venta, 2)}</td>
                                <td><span class="badge badge-${estado}">${producto.estado}</span></td>
                                <td>
                                    <a href="${RUTA}sistema/productos/${producto.id}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    }
                    setTimeout(() => {
                        contenedor.html(cuerpo);
                    }, 500);
                    paginar(pagina_actual, data.total);
                    $(".paginacionTickets").on('click', function (e) {
                        pagina_actual = $(this).attr('data-id-page');
                        traerProductos();
                    });
                } else {
                    $("#paginacion").html("");
                    contenedor.html(`
                        <a class="dropdown-item" href="#">No hay resultados</a>
                    `);
                }
            }
        });
    }

    function filtros() {
        $("#filtro_tipo").change(function () {
            filtro_tipo = $(this).val();
            traerProductos();
            pagina_actual = 1;
        });

        $("#search_product").change(function () {
            filtro_busqueda = $(this).val();
            traerProductos();
            pagina_actual = 1;
        });
    }
    function paginar(pagina, paginas) {
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

        var cuerpo = `<ul class="pagination">`;
        cuerpo += ` <li class="page-item ${((pagina <= 1) ? " disabled" : "")}"><a class="page-link paginacionTickets" ${((pagina <= 1) ? "" : 'data-id-page="' + (pagina - 1) + '"')}>Previous</a></li>`;

        if (pagina >= elementosCard) {
            cuerpo += `<li class="page-item ${((pagina <= 1) ? " disabled" : "")}"><a class="page-link paginacionTickets" data-id-page="1">1.. </a></li>`;
        }

        for (i; i <= limite; i++) {
            cuerpo += `<li class="page-item ${((i == pagina) ? " active" : " ")}"><a class="page-link ${((i == pagina) ? '' : 'paginacionTickets')} " data-id-page="${i} ">${i}</a></li>`;
        }
        cuerpo += `<li class="page-item ${((pagina >= paginas) ? " disabled" : "")}" ><a class="page-link paginacionTickets" ${((pagina >= paginas) ? "" : 'data-id-page="' + (parseInt(pagina) + 1) + '"')} >Next</a></li>`;
        cuerpo += (pagina != paginas) ? `<li class="page-item ${((pagina >= paginas) ? " disabled" : "")}" ><a class="page-link paginacionTickets" data-id-page="${paginas}"><i class="fa fa-fast-forward" aria-hidden="true"></i> </a></li>` : "";
        cuerpo += `</ul>`;
        $("#paginacion").html(cuerpo);
    }
    /**
     * APARTADO PARA CREAR PUBLICACIÓN
     */
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $progress = $('#progresoPub');
    var $progressBar = $('#progresoPubBarra');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;

    var $progressPub = $("#progressPub");
    loading(50);
    function loading(tiempo, limite = 75) {
        $progressPub.width(tiempo + '%').attr('aria-valuenow', tiempo).text(tiempo + '%');
    }

    $('[data-toggle="tooltip"]').tooltip();
    $("#buscarImagen").on('click', function (e) {
        e.preventDefault();
        $("#input").click();
        $(this).hide();
    })
    input.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            input.value = '';
            image.src = url;
            $alert.hide();
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    $("#formPublicacion").on('submit', function (e) {
        e.preventDefault();
        Swal.fire(
            'Atento!',
            'Debes de seleccionar una imagen',
            'error'
        );
    });
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: .9,
            viewMode: 3,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });
    $("#editarFoto").on('click', function () {
        $("#avatar").click();
    });

    document.getElementById('crop').addEventListener('click', function () {
        var initialAvatarURL;
        var canvas;

        $modal.modal('hide');

        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 1000,
                height: 1000,
            });
            initialAvatarURL = avatar.src;
            avatar.src = canvas.toDataURL();
            $progress.show();
            $alert.removeClass('alert-success alert-warning');
            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('avatar', blob, 'avatar.jpg'); //envio de la imagen
                formData.append('opcion', 'crear'); //Añadir POST
                $("#avatar").show();
                $("#formPublicacion").off().on('submit', function (e) {
                    e.preventDefault();
                    let nombre = $("#nombre").val();
                    let descripcion = $("#descripcionProducto").val();
                    let precio_compra = $("#precio_compra").val();
                    let precio_venta = $("#precio_venta").val();
                    let codigo = $("#codigo").val();
                    let stock = $("#stock").val();
                    let minStok = $("#min-stok").val();
                    let selCategoria = $("#selCategoria").val();
                    let productoPublico = $("#productoPublico").is(":checked");

                    formData.append('nombre', nombre); //Añadir POST
                    formData.append('descripcion', descripcion); //Añadir POST
                    formData.append('precio_compra', precio_compra); //Añadir POST
                    formData.append('precio_venta', precio_venta); //Añadir POST
                    formData.append('codigo', codigo); //Añadir POST
                    formData.append('stock', stock); //Añadir POST
                    formData.append('minStok', minStok); //Añadir POST
                    formData.append('selCategoria', selCategoria); //Añadir POST
                    formData.append('productoPublico', productoPublico); //Añadir POST

                    if (nombre == "" || nombre.length < 3) {
                        Swal.fire(
                            'Atento!',
                            response.Texto,
                            'error'
                        );
                    } else if (descripcion == "" || descripcion.length < 4) {
                        let texto = (descripcion.length > 250) ? "  larga" : " corta";
                        Swal.fire(
                            'Atento!',
                            `Tu descripcion es demaciado ${texto}`,
                            'error'
                        );
                    } else {
                        $.ajax(RUTA + 'back/productos', {
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            xhr: function (load) {
                                var xhr = new XMLHttpRequest();

                                xhr.upload.onprogress = function (e) {
                                    var percent = '0';
                                    var percentage = '0%';
                                    if (e.lengthComputable) {
                                        percent = Math.round((e.loaded / e.total) * 99);
                                        percentage = percent + '%';
                                        $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                                    }
                                };

                                return xhr;
                            },

                            success: function (response) {
                                if (response.respuesta == "exito") {
                                    $progressBar.width('100%').attr('aria-valuenow', 100).text('100%');
                                    setTimeout(() => {
                                        $alert.show().addClass('alert-success').text(response.Texto);
                                    }, 1000);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                    Swal.fire(
                                        'Exito!',
                                        response.Texto,
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        '¡ERROR!',
                                        response.Texto,
                                        'error'
                                    )
                                }
                            },

                            error: function (xhr, status) {
                                console.log(xhr.responseText);
                                avatar.src = initialAvatarURL;
                                $alert.show().addClass('alert-warning').text('Error al realizar la publicación');
                            },
                        });
                    }

                })
            });
        }
    });
    /**
     * FIN APARTADO PARA CREAR PUBLICACIÓN
     */
});