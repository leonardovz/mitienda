$(document).ready(function () {
    var estado_edicion = true;
    traerCategorias();
    $("#add_categoria").on('submit', function (e) {
        e.preventDefault();
        let button = $("#action_categoria");
        var nombre = $("#name_categoria").val();
        if (nombre.length > 3) {
            crearCategoria(nombre, button);
        } else {
            Swal.fire(
                '¡Atento!',
                'El nombre es demaciado corto',
                'warning'
            );
        }
    });
    function traerCategorias() {
        estado_edicion = true;
        let contenedor = $("#categoriasList");
        contenedor.html(`
            <div class="spinner-border text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `);
        $.ajax({
            type: "POST",
            url: RUTA + 'back/categorias',
            dataType: "json",
            data: `opcion=mostrar&location=system`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let cuerpo = "";
                    let categorias = data.categorias;
                    for (const i in categorias) {
                        let categoria = categorias[i].categoria;
                        cuerpo +=
                            `<li data-id-categoria="${categoria.id}" data-nombre-categoria="${categoria.categoria}" data-estado-categoria="${categoria.estado}">
                                <div class="d-inline ml-2">
                                    <label><i class="${((categoria.estado == 'activo') ? "fas fa-check-circle text-success " : "fab fa-rev text-danger")}"></i></label>
                                </div>
                                <span class="text">${categoria.categoria}</span>
                                <small class="badge badge-danger">${categorias[i].total_productos} prod</small>
                                <div class="tools modificar_categoria" >
                                    <i class="fas fa-edit"></i>
                                </div>
                            </li>`;
                    }
                    contenedor.html(`
                        <ul class="todo-list">
                            ${cuerpo}
                        </ul>
                    `);
                    editar();
                } else {
                    contenedor.html(`
                    <div class="alert alert-danger" role="alert">
                       ${data.Texto}
                    </div>
                    `);
                }
            }
        });
    }
    function editar() {

        $(".modificar_categoria").on('click', function () {
            if (!estado_edicion) {
                Swal.fire(
                    '¡Atento!',
                    'Termina de editar la categoria seleccionada',
                    'warning'
                );
            } else {
                estado_edicion = false;
                let categoria = $(this).parent();
                let id_categoria = categoria.attr('data-id-categoria');
                let nombre_categoria = categoria.attr('data-nombre-categoria');
                let estado_categoria = categoria.attr('data-estado-categoria');

                categoria.html(`
                    <form class="form-inline md-form" id="form_edit_categoria">
                        <select class="browser-default custom-select text-dark w-25" id="id_estado" required>
                            <option value="activo"${(estado_categoria == 'activo') ? " selected " : ""}>Activa</option>
                            <option value="inactivo"${(estado_categoria == 'inactivo') ? " selected " : ""}>Inactiva</option>
                        </select>    
                        <input class="form-control w-50 ml-3" id="name_edit_categoria" type="text" placeholder="Categoria" aria-label="Editar nombre" value="${nombre_categoria}">
                        <button type="submit" class="btn btn-success px-3 btn-sm" id="save_edit"><i class="fas fa-check-circle"></i></button>
                        <a class="btn btn-warning px-3 btn-sm"><i class="fas fa-window-close" id="calcel_edit"></i></a>
                        <a class="btn btn-danger px-3 btn-sm" id="eliminar_cat"><i class="fas fa-trash-alt" ></i></a>
                    </form>
                `);
                $("#form_edit_categoria").on('submit', function (e) {
                    e.preventDefault();
                    estado_categoria = $("#id_estado").val();
                    nombre_categoria = $("#name_edit_categoria").val();
                    editarCategoria(id_categoria, nombre_categoria, estado_categoria, $("#save_edit"));
                });
                $("#calcel_edit").on('click', function () {
                    estado_edicion = true;
                    traerCategorias();
                });
                $("#eliminar_cat").on('click', function () {
                    let boton = $(this);
                    Swal.fire({
                        title: '¿Estas Seguro?',
                        text: "Si registraste un producto en esta categoria, no podrias eliminarla!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: RUTA + 'back/categorias',
                                dataType: "json",
                                data: `opcion=eliminar&id=${id_categoria}`,
                                error: function (xhr, resp) {
                                    console.log(xhr.responseText);
                                    setTimeout(() => {
                                        boton.removeClass("disabled");
                                    }, 500);
                                },
                                success: function (data) {
                                    if (data.respuesta == "exito") {
                                        traerCategorias();
                                    } else {
                                        Swal.fire(
                                            '¡Atento!',
                                            data.Texto,
                                            'warning'
                                        );
                                    }
                                    setTimeout(() => {
                                        boton.removeClass("disabled");
                                    }, 500);
                                }
                            });
                        }
                    })

                });
            }
        });



    }
    function editarCategoria(idCategoria, nombre, status, button) {
        button.addClass("disabled");
        $.ajax({
            type: "POST",
            url: RUTA + 'back/categorias',
            dataType: "json",
            data: `opcion=editar&nombre=${nombre}&estado=${status}&id=${idCategoria}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
                setTimeout(() => {
                    button.removeClass("disabled");
                }, 500);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    traerCategorias();
                } else {
                    Swal.fire(
                        '¡Atento!',
                        data.Texto,
                        'warning'
                    );
                }
                setTimeout(() => {
                    button.removeClass("disabled");
                }, 500);
            }
        });
    }

    function crearCategoria(nombre, button) {
        button.addClass("disabled");
        button.html(`Creando...`);
        $.ajax({
            type: "POST",
            url: RUTA + 'back/categorias',
            dataType: "json",
            data: `opcion=crear&nombre=${nombre}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
                setTimeout(() => {
                    button.removeClass("disabled");
                    button.html(`Ingresar`);
                }, 500);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    traerCategorias();
                    $("#name_categoria").val('');
                } else {
                    Swal.fire(
                        '¡Atento!',
                        data.Texto,
                        'warning'
                    );
                }
                setTimeout(() => {
                    button.removeClass("disabled");
                    button.html(`Ingresar`);
                }, 500);
            }
        });
    }
});