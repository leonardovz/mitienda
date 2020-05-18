$(document).ready(function () {

    $("#cancel_user").on('click', function () {
        $("#cont_usuarios").hide();
    })
    $("#nuevo_usuario").on('click', function () {
        $("#cont_usuarios").show();
    })
    $("#form_usuarios").on('submit', function (e) {
        e.preventDefault();
        var formulario = $(this).serialize();
        let nombre = $("#nombre").val();
        let apellidos = $("#apellidos").val();
        let correo = $("#correo").val();
        let tipo_user = $("#tipo_user").val();

        var body_error = $("#body_error");
        var cont_error = 0;
        body_error.html("");
        if (nombre.length < 4 && nombre != 'undefined') {
            body_error.append(dangerAlert('ERROR', `No completasde de manera correcta el campo Nombre`));
            cont_error++;
        }
        if (apellidos.length < 4 && apellidos != 'undefined') {
            body_error.append(dangerAlert('ERROR', `No completasde de manera correcta el campo Apellidos`));
            cont_error++;
        }
        if (correo.length < 4 && correo != 'undefined') {
            body_error.append(dangerAlert('ERROR', `No completasde de manera correcta el campo Correo`));
            cont_error++;
        }
        if (tipo_user.length < 4 && tipo_user != 'undefined' && (tipo_user != 'administradors' && tipo_user != 'vendedor')) {
            body_error.append(dangerAlert('ERROR', `No completasde de manera correcta el campo tipoUser`));
            cont_error++;
        }

        if (cont_error == 0) {
            $.ajax({
                type: "POST",
                url: RUTA + 'back/usuarios',
                dataType: "json",
                data: `opcion=crear&${formulario}`,
                error: function (xhr, resp) {
                    console.log(xhr.responseText);
                },
                success: function (data) {
                    if (data.respuesta == "exito") {
                        Swal.fire(
                            'Excelente!',
                            data.Texto,
                            'success'
                        );
                        traer_usuarios();
                    } else {
                        Swal.fire(
                            'Opss!',
                            data.Texto,
                            'error'
                        );
                    }
                }
            });
        }

    });
    traer_usuarios();
    function dangerAlert(title, text) {
        return `
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5 class="text-white"><i class="icon fas fa-ban"></i> ${title}</h5>
            ${text}
        </div>
        `;
    }

    function traer_usuarios() {
        $.ajax({
            type: "POST",
            url: RUTA + 'back/usuarios',
            dataType: "json",
            data: `opcion=mostrar`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let cuerpo = '';
                    for (const i in data.usuarios) {
                        cuerpo += fila_tabla(data.usuarios[i].usuario);
                    }

                    $("#table_user").html(`
                         
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>IMG</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Correo</th>
                                <th>cargo</th>
                                <th>tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${cuerpo}
                        </tbody>
                    </table>
                    `);
                } else {

                }
            }
        });
    }
    function fila_tabla(usuario) {
        return `
        <tr>
            <td>
                <div class="product-img">
                    <img src="${RUTA}galeria/img/default-user.jpg" alt="Product Image" class="img-size-50">
                </div>
            </td>
            <td><a href="${RUTA}sistema/account/${usuario.id}">${usuario.nombre}</a></td>
            <td>${usuario.apellidos}</td>
            <td>
                <div class="sparkbar" data-color="#00a65a" data-height="20">${usuario.correo}</div>
            </td>
            <td>${usuario.cargo}</td>
            <td>
                <a href="${RUTA}sistema/account/${usuario.id}">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>`;

    }
});